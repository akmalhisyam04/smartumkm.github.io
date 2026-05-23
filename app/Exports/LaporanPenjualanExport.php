<?php

namespace App\Exports;

use App\Models\LaporanPenjualan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanPenjualanExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize
{

    public function collection()
    {
        return LaporanPenjualan::select(
            'tanggal_laporan',
            'total_penjualan',
            'jumlah_penjualan'
        )->get();
    }

    public function headings(): array
    {
        return [

            'Tanggal Laporan',
            'Total Penjualan',
            'Jumlah Penjualan'

        ];
    }
}