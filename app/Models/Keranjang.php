<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjangs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_barang',
        'id_pelanggan',
        'qty',
        'keterangan',
        'sub_total',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
   

    /**
     * Get the item (barang) associated with the detail pesanan.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    /**
     * Get the customer (pelanggan) associated with the detail pesanan.
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}
