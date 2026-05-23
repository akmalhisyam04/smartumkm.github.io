<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('pengguna')->get();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $user = User::all();

        return view('transaksi.create', compact('user'));
    }

    public function store(Request $request)
    {
        Transaksi::create([
            'kode_transaksi' => $request->kode_transaksi,
            'pengguna_id' => $request->pengguna_id,
            'total_harga' => $request->total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_transaksi' => $request->tanggal_transaksi
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $user = User::all();

        return view('transaksi.edit', compact('transaksi', 'user'));
    }

    public function update(Request $request, int $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'kode_transaksi' => $request->kode_transaksi,
            'pengguna_id' => $request->pengguna_id,
            'total_harga' => $request->total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_transaksi' => $request->tanggal_transaksi
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diupdate');
    }

    public function destroy(int $id)
    {
        Transaksi::destroy($id);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}