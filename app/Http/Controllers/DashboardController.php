<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek login via session
        if (!session('login')) {
            return redirect()->route('login');
        }

        $userRole = session('role');
        
        // Data dasar
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();
        
        // Data transaksi (hanya untuk role yang berhak)
        if (in_array($userRole, ['admin', 'kasir', 'pemilik'])) {
            $totalTransaksi = Transaksi::count();
            $totalPendapatan = Transaksi::sum('total_harga');
            $totalStokTerjual = DetailTransaksi::sum('jumlah');
            $transaksiBulanIni = Transaksi::whereMonth('created_at', date('m'))->count();
            $transaksiTerbaru = Transaksi::with('pengguna')->latest()->take(5)->get();
        } else {
            $totalTransaksi = 0;
            $totalPendapatan = 0;
            $totalStokTerjual = 0;
            $transaksiBulanIni = 0;
            $transaksiTerbaru = collect([]);
        }
        
        // Insight stok menipis
        $produkStokMenipis = Produk::where('stok', '<=', 10)
                            ->orderBy('stok', 'asc')
                            ->first();
        
        return view('dashboard', compact(
            'totalProduk', 'totalKategori', 'totalTransaksi',
            'totalPendapatan', 'totalStokTerjual', 'transaksiBulanIni',
            'transaksiTerbaru', 'produkStokMenipis', 'userRole'
        ));
    }
}