<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $tables = 'transaksis';
    protected $fillable = [
        'id_user',
        'id_pelanggan',
        'tanggal_pesan',
        'tanggal_ambil',
        'total_harga',
        'total_bayar',
        // 'model_bayar',
        'status_pesanan',
        'status_ambil',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
   

    /**
     * Get the user associated with the order.
     */
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id_user');
    // }

    /**
     * Get the customer associated with the order.
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}
