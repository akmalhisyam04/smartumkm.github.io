<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;

class DetailTransaksiController extends Controller
{
    public function index()
    {
        $detail = DetailTransaksi::with('transaksi', 'produk')->get();

        return view('detail_transaksi.index', compact('detail'));
    }

    public function create()
    {
        $transaksi = Transaksi::all();
        $produk = Produk::all();

        return view('detail_transaksi.create', compact('transaksi', 'produk'));
    }

    public function edit(int $id)
    {
        $detail = DetailTransaksi::findOrFail($id);

        $transaksi = Transaksi::all();

        $produk = Produk::all();

        return view('detail_transaksi.edit', compact(
            'detail',
            'transaksi',
            'produk'
        ));
    }

    public function update(Request $request, int $id)
    {
        $detail = DetailTransaksi::findOrFail($id);

        $detail->update([

            'transaksi_id' => $request->transaksi_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'subtotal' => $request->subtotal,

        ]);

        return redirect()->route('detail-transaksi.index');
    }

    public function store(Request $request)
    {
        DetailTransaksi::create([
            'transaksi_id' => $request->transaksi_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'subtotal' => $request->subtotal
        ]);

        return redirect()->route('detail-transaksi.index')
            ->with('success', 'Detail transaksi berhasil ditambahkan');
    }

    public function destroy(int $id)
    {
        DetailTransaksi::destroy($id);

        return redirect()->route('detail-transaksi.index')
            ->with('success', 'Detail transaksi berhasil dihapus');
    }
}