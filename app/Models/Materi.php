<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;
    protected $tables = 'materis';
    
    public $timestamps = true;
    public $fillable = ['nama_materi','file_materi'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas','id');
    }
}
