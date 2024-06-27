<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $tables = 'pelanggans';
    
    public $timestamps = true;
    public $fillable = ['name','alamat','no_hp','id_user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan');
    }
    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'id_pelanggan');
    }
}
