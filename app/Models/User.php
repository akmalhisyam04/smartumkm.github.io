<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    protected $fillable = [
        'username',
        'password',
        'role'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pengguna_id');
    }
}