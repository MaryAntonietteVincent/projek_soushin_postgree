<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAcara extends Model
{
    use HasFactory;
    protected $tables = 'jenis_acaras';
    
    public $timestamps = true;
    public $fillable = ['jenis_acara'];

    public function events()
    {
        return $this->hasMany(events::class, 'id_jenisacara');
    }
}
