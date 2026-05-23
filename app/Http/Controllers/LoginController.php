<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    // =======================
    // TAMPILKAN HALAMAN LOGIN
    // =======================

    public function index()
    {
        return view('login');
    }

    // =======================
    // PROSES LOGIN
    // =======================

    public function prosesLogin(Request $request)
    {
        $user = User::query()
                    ->where('username', $request->username)
                    ->where('password', $request->password)
                    ->first();

        if ($user) {

            session([
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'login' => true
            ]);

            return redirect('/dashboard');
        }

        return redirect('/')
            ->with('error', 'Username atau Password salah');
    }

    // =======================
    // LOGOUT
    // =======================

    public function logout()
    {
        session()->flush();

        return redirect('/');
    }
}