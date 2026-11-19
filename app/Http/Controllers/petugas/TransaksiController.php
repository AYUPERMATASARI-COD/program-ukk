<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransaksiController extends Controller
{
    public function create()
    {
        $areas = AreaParkir::orderBy('nama_area')->get();
        $kendaraanAktifPerArea = Transaksi::query()
            ->join('kendaraans', 'transaksis.kendaraan_id', '=', 'kendaraans.id')
            ->where('transaksis.status', 'masuk')
            ->whereNotNull('kendaraans.area_id')
            ->selectRaw('kendaraans.area_id, COUNT(*) as total')
            ->groupBy('kendaraans.area_id')
            ->pluck('total', 'kendaraans.area_id');
        $kapasitasTersedia = $areas->mapWithKeys(fn (AreaParkir $area): array => [
            $area->id => max(0, $area->kapasitas - (int) $kendaraanAktifPerArea->get($area->id, 0)),
        ]);
        $tarifs = Tarif::all()->keyBy('jenis_kendaraan');

        return view('petugas.transaksi.masuk', compact('areas', 'kapasitasTersedia', 'tarifs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plat_nomor' => ['required', 'string', 'max:20'],
            'jenis_kendaraan' => ['required', 'in:motor,mobil,bis,truk'],
            'warna' => ['required', 'string', 'max:50'],
            'nama_pemilik' => ['nullable', 'string', 'max:100'],
            'area_id' => ['required', 'exists:area_parkirs,id'],
        ]);

        $transaksi = DB::transaction(function () use ($validated): Transaksi {
            $area = AreaParkir::query()
                ->lockForUpdate()
                ->findOrFail($validated['area_id']);

            $kendaraanAktif = Transaksi::query()
                ->where('status', 'masuk')
                ->whereHas('kendaraan', function ($query) use ($area): void {
                    $query->where('area_id', $area->id);
                })
                ->count();

            if ($kendaraanAktif >= $area->kapasitas) {
                throw ValidationException::withMessages([
                    'area_id' => 'Area parkir sudah penuh. Silakan pilih area lain.',
                ]);
            }

            $kendaraan = Kendaraan::updateOrCreate(
                ['plat_nomor' => strtoupper($validated['plat_nomor'])],
                [
                    'jenis_kendaraan' => $validated['jenis_kendaraan'],
                    'warna' => $validated['warna'],
                    'nama_pemilik' => $validated['nama_pemilik'] ?? null,
                    'area_id' => $validated['area_id'],
                ]
            );

            $transaksi = Transaksi::create([
                'kendaraan_id' => $kendaraan->id,
                'user_id' => auth()->id(),
                'waktu_masuk' => now(),
                'status' => 'masuk',
            ]);

            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Kendaraan masuk',
                'keterangan' => 'Plat '.$kendaraan->plat_nomor.' masuk ke area '.$area->nama_area.'.',
            ]);

            return $transaksi;
        });

        return redirect()->route('petugas.transaksi.cetak', $transaksi)
            ->with('success', 'Kendaraan '.$transaksi->kendaraan->plat_nomor.' berhasil dicatat masuk.');
    }

    public function keluar()
    {
        $transaksis = Transaksi::with('kendaraan')
            ->where('status', 'masuk')
            ->latest('waktu_masuk')
            ->get();

        return view('petugas.transaksi.keluar', compact('transaksis'));
    }

    public function prosesKeluarDenganId(Request $request)
    {
        $validated = $request->validate([
            'transaksi_id' => ['required', 'integer', 'min:1'],
        ]);

        $transaksi = Transaksi::query()
            ->whereKey($validated['transaksi_id'])
            ->where('status', 'masuk')
            ->first();

        if (! $transaksi) {
            throw ValidationException::withMessages([
                'transaksi_id' => 'ID tiket tidak ditemukan atau kendaraan sudah keluar.',
            ]);
        }

        return $this->prosesKeluar($transaksi);
    }

    public function prosesKeluar(Transaksi $transaksi)
    {
        abort_if($transaksi->status !== 'masuk', 422, 'Transaksi sudah selesai.');

        $transaksi->load('kendaraan');
        $tarif = Tarif::where('jenis_kendaraan', $transaksi->kendaraan->jenis_kendaraan)->first();

        abort_unless($tarif, 422, 'Tarif kendaraan belum diatur.');

        $waktuKeluar = now();
        $totalMenit = max(1, $transaksi->waktu_masuk->diffInMinutes($waktuKeluar));
        $totalJam = max(1, (int) ceil($totalMenit / 60));
        $totalBayar = $tarif->tarif_awal + max(0, $totalJam - 1) * $tarif->tarif_perjam;

        $transaksi->update([
            'user_id' => auth()->id(),
            'waktu_keluar' => $waktuKeluar,
            'total_bayar' => $totalBayar,
            'status' => 'keluar',
        ]);
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Kendaraan keluar',
            'keterangan' => 'Plat '.$transaksi->kendaraan->plat_nomor.' keluar dengan pembayaran Rp'.number_format($totalBayar, 0, ',', '.').'.',
        ]);

        return redirect()->route('petugas.transaksi.cetak', $transaksi);
    }

    public function cetak(Transaksi $transaksi)
    {
        abort_unless(in_array($transaksi->status, ['masuk', 'keluar'], true), 404);

        $transaksi->load('kendaraan.area', 'user');
        $tarif = $transaksi->kendaraan
            ? Tarif::where('jenis_kendaraan', $transaksi->kendaraan->jenis_kendaraan)->first()
            : null;

        return view('petugas.transaksi.cetak', compact('transaksi', 'tarif'));
    }
}
