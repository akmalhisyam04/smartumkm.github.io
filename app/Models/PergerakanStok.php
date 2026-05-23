<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PergerakanStok extends Model
{
    protected $table = 'pergerakan_stok';

    protected $primaryKey = 'id_stok';

    public $timestamps = false;

    protected $fillable = [
        'produk_id',
        'jenis',
        'jumlah',
        'keterangan',
        'created_at'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}