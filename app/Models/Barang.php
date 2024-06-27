<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $tables = 'barangs';
    
    public $timestamps = true;
    public $fillable = ['nama_produk','harga','deskripsi','gambar'];

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'id_barang');
    }
public function detail_transaksi(){

    return $this->hasMany(Detailtransaksi::class, 'id_barang');
}

}
