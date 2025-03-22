<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'date_start',
        'date_end',
        'description',
        'type',
        'city',
        'location',
        'owner_id',
        'is_public',
    ];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime'
    ];
}
