<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'no_hp' => 'required|string|max:15',
            'role' => 'required|in:pencari,pemilik'
        ]);

        $user = User::create([
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'], // will be hashed by User mutator into password_hash
            'no_hp' => $validatedData['no_hp'],
            'role' => $validatedData['role']
        ]);

        Auth::login($user);
        return redirect('/home')->with('success', 'Registrasi berhasil');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('/home')->with('success', 'Login berhasil');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showProfile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email,' . Auth::id() . ',user_id',
            'no_hp' => 'required|string|max:15',
        ]);

        /** @var User $user */
        $user = Auth::user();
        if ($user) {
            $user->update($validatedData);
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
