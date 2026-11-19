<?php

namespace Tests\Feature;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetugasTransaksiTest extends TestCase
{
    use RefreshDatabase;

    public function test_rejects_entry_when_parking_area_is_full(): void
    {
        $petugas = User::factory()->create([
            'username' => 'petugas',
            'role' => 'petugas',
        ]);
        $area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 1,
        ]);
        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B 1111 AA',
            'jenis_kendaraan' => 'motor',
            'area_id' => $area->id,
        ]);
        Transaksi::create([
            'kendaraan_id' => $kendaraan->id,
            'user_id' => $petugas->id,
            'waktu_masuk' => now(),
            'status' => 'masuk',
        ]);

        $response = $this->actingAs($petugas)
            ->from(route('petugas.transaksi.masuk'))
            ->post(route('petugas.transaksi.masuk.store'), [
                'plat_nomor' => 'B 2222 BB',
                'jenis_kendaraan' => 'motor',
                'warna' => 'Hitam',
                'area_id' => $area->id,
            ]);

        $response->assertRedirectBackWithErrors(['area_id']);
        $response->assertSessionHasErrors([
            'area_id' => 'Area parkir sudah penuh. Silakan pilih area lain.',
        ]);
        $this->assertDatabaseCount('transaksis', 1);
        $this->assertDatabaseMissing('kendaraans', ['plat_nomor' => 'B 2222 BB']);
    }

    public function test_accepts_entry_when_parking_area_has_capacity(): void
    {
        $petugas = User::factory()->create([
            'username' => 'petugas',
            'role' => 'petugas',
        ]);
        $area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 2,
        ]);
        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B 1111 AA',
            'jenis_kendaraan' => 'motor',
            'area_id' => $area->id,
        ]);
        Transaksi::create([
            'kendaraan_id' => $kendaraan->id,
            'user_id' => $petugas->id,
            'waktu_masuk' => now(),
            'status' => 'masuk',
        ]);

        $response = $this->actingAs($petugas)
            ->post(route('petugas.transaksi.masuk.store'), [
                'plat_nomor' => 'B 2222 BB',
                'jenis_kendaraan' => 'motor',
                'warna' => 'Hitam',
                'area_id' => $area->id,
            ]);

        $transaksiMasuk = Transaksi::where('status', 'masuk')->latest('id')->firstOrFail();
        $response->assertRedirect(route('petugas.transaksi.cetak', $transaksiMasuk));
        $response->assertSessionHas('success', 'Kendaraan B 2222 BB berhasil dicatat masuk.');
        $this->assertDatabaseHas('kendaraans', [
            'plat_nomor' => 'B 2222 BB',
            'warna' => 'Hitam',
            'area_id' => $area->id,
        ]);
        $this->assertDatabaseHas('log_aktivitas', [
            'user_id' => $petugas->id,
            'aktivitas' => 'Kendaraan masuk',
            'keterangan' => 'Plat B 2222 BB masuk ke area Area A.',
        ]);
        $this->assertDatabaseCount('transaksis', 2);

        $tiketMasuk = $this->actingAs($petugas)->get(route('petugas.transaksi.cetak', $transaksiMasuk));
        $tiketMasuk->assertOk();
        $tiketMasuk->assertSee('Tiket masuk kendaraan');
        $tiketMasuk->assertSee('Tiket ini wajib ditunjukkan untuk masuk ke area parkir.');
        $tiketMasuk->assertSee('#'.$transaksiMasuk->id);
    }

    public function test_entry_form_displays_hourly_rate_for_each_vehicle_type(): void
    {
        $petugas = User::factory()->create([
            'username' => 'petugas',
            'role' => 'petugas',
        ]);
        Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_awal' => 3000,
            'tarif_perjam' => 2000,
        ]);

        $response = $this->actingAs($petugas)->get(route('petugas.transaksi.masuk'));

        $response->assertOk();
        $response->assertSee('Motor - Rp 2.000/jam');
        $response->assertSee('Mobil - Tarif belum diatur');
    }

    public function test_entry_form_displays_remaining_capacity_after_vehicle_enters(): void
    {
        $petugas = User::factory()->create([
            'username' => 'petugas',
            'role' => 'petugas',
        ]);
        $area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 2,
        ]);
        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B 1111 AA',
            'jenis_kendaraan' => 'motor',
            'area_id' => $area->id,
        ]);
        Transaksi::create([
            'kendaraan_id' => $kendaraan->id,
            'user_id' => $petugas->id,
            'waktu_masuk' => now(),
            'status' => 'masuk',
        ]);

        $response = $this->actingAs($petugas)->get(route('petugas.transaksi.masuk'));

        $response->assertOk();
        $response->assertSee('Area A (Sisa 1/2)');
    }

    public function test_exit_flow_shows_transaction_id_and_payment_ticket(): void
    {
        $petugas = User::factory()->create([
            'username' => 'petugas',
            'role' => 'petugas',
        ]);
        Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_awal' => 3000,
            'tarif_perjam' => 2000,
        ]);
        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B 1111 AA',
            'jenis_kendaraan' => 'motor',
            'warna' => 'Hitam',
        ]);
        $transaksi = Transaksi::create([
            'kendaraan_id' => $kendaraan->id,
            'user_id' => $petugas->id,
            'waktu_masuk' => now()->subHours(5),
            'status' => 'masuk',
        ]);

        $kendaraanLain = Kendaraan::create([
            'plat_nomor' => 'B 2222 BB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'Putih',
        ]);
        $transaksiLain = Transaksi::create([
            'kendaraan_id' => $kendaraanLain->id,
            'user_id' => $petugas->id,
            'waktu_masuk' => now(),
            'status' => 'masuk',
        ]);

        $daftarKeluar = $this->actingAs($petugas)->get(route('petugas.transaksi.keluar'));
        $daftarKeluar->assertSee('#'.$transaksi->id);
        $daftarKeluar->assertSee('Bayar & keluar');
        $daftarKeluar->assertSee('ID tiket masuk');

        $response = $this->post(route('petugas.transaksi.keluar.id'), [
            'transaksi_id' => $transaksi->id,
        ]);
        $response->assertRedirect(route('petugas.transaksi.cetak', $transaksi));
        $this->assertDatabaseHas('transaksis', [
            'id' => $transaksi->id,
            'status' => 'keluar',
            'total_bayar' => 13000,
        ]);
        $this->assertDatabaseHas('transaksis', [
            'id' => $transaksiLain->id,
            'status' => 'masuk',
        ]);

        $tiketKeluar = $this->get(route('petugas.transaksi.cetak', $transaksi));
        $tiketKeluar->assertOk();
        $tiketKeluar->assertSee('Bukti pembayaran kendaraan keluar');
        $tiketKeluar->assertSee('#'.$transaksi->id);
        $tiketKeluar->assertSee('Rp 13.000');
    }
}
