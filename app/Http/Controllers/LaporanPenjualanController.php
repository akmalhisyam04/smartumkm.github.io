<?php

namespace App\Http\Controllers;

use App\Models\LaporanPenjualan;
use App\Exports\LaporanPenjualanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPenjualanController extends Controller
{
    public function index()
    {
        $laporan = LaporanPenjualan::all();

        return view('laporan.index', compact('laporan'));
    }

    public function exportExcel()
    {
        return Excel::download(
            new LaporanPenjualanExport,
            'laporan_penjualan.xlsx'
        );
    }
}