<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Attendee;

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

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function invitations() {
        return $this->hasMany(Invitation::class);
    }

    public function attendees() {
        return $this->hasMany(Attendee::class);
    }
}
