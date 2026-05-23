<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga_jual',
        'harga_modal',
        'stok',
        'kategori_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id');
    }

    public function pergerakanStok()
    {
        return $this->hasMany(PergerakanStok::class, 'produk_id');
    }
}