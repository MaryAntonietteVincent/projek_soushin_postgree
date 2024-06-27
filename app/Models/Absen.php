<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absens';

    // Specify the primary key if it's different from 'id'
    protected $primaryKey = 'id';

    // Define which attributes can be mass assignable
    protected $fillable = [
        'id_pelanggan',
        'id_jadwal',
        'status',
        'bukti_surat',
        'tanggal',
    ];

    // Define the relationship with the Pelanggan model
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Define the relationship with the Jadwal model
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal');
    }
}
