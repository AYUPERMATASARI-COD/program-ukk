<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = User::where('username', $request->string('username'))->first();

            if ($user && $user->password === $request->input('password')) {
                $user->password = Hash::make($request->input('password'));
                $user->save();

                Auth::login($user, $request->boolean('remember'));
            } else {
                return back()
                    ->withErrors(['username' => 'Username atau password salah.'])
                    ->onlyInput('username');
            }
        }

        $request->session()->regenerate();

        $user = Auth::user();
        LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => 'Login',
            'keterangan' => 'Pengguna '.$user->username.' berhasil login.',
        ]);

        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),
            'owner' => redirect()->route('owner.dashboard'),
            default => tap(back()->withErrors([
                'username' => 'Role akun belum memiliki halaman tujuan.',
            ]), fn () => Auth::logout()),
        };
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user !== null) {
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Logout',
                'keterangan' => 'Pengguna '.$user->username.' logout.',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
