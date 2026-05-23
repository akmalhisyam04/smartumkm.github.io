<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('user.index', compact('user'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        User::create([
            'username' => $request->username,
            'password' => $request->password,
            'role' => $request->role
        ]);

        return redirect()->route('user.index')
            ->with('success', 'Data user berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'username' => $request->username,
            'password' => $request->password,
            'role' => $request->role
        ]);

        return redirect()->route('user.index')
            ->with('success', 'Data user berhasil diupdate');
    }

    public function destroy(int $id)
    {
        User::destroy($id);

        return redirect()->route('user.index')
            ->with('success', 'Data user berhasil dihapus');
    }
}