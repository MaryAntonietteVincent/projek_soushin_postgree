<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailtransaksi extends Model
{
    use HasFactory;
    protected $table = 'detailtransaksis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'qty',
       
        'sub_total',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    

    /**
     * Get the transaction associated with the detail.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    /**
     * Get the item associated with the detail.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
