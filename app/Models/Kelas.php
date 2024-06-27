<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $tables = 'kelas';
    
    public $timestamps = true;
    public $fillable = ['kelas'];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_kelas');
    }
    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_kelas');
    }
}
