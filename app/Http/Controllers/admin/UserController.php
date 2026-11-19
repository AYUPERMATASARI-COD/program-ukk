<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
        })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas,owner',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Tambah pengguna',
            'keterangan' => 'Pengguna '.$user->username.' dengan role '.$user->role.' ditambahkan.',
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,petugas,owner',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Ubah pengguna',
            'keterangan' => 'Data pengguna '.$user->username.' diperbarui.',
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $username = $user->username;
        $user->delete();
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Hapus pengguna',
            'keterangan' => 'Pengguna '.$username.' dihapus.',
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
