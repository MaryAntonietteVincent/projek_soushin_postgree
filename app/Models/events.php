<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    use HasFactory;
    
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'organizer',

        'status',
        'image_event',
        'id_jenisacara',
        'capacity',
        'price'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    

    /**
     * Get the related 'JenisAcara' for the event.
     */
    public function jenisAcara()
    {
        return $this->belongsTo(JenisAcara::class, 'id_jenisacara');
    }
}
