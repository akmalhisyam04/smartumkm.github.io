<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPenjualan extends Model
{
    protected $table = 'laporan_penjualan';

    protected $primaryKey = 'id_laporan';

    public $timestamps = false;

    protected $fillable = [
        'tanggal_laporan',
        'total_penjualan',
        'jumlah_penjualan',
        'created_at'
    ];
}