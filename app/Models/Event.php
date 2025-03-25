<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\EventType;
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

    public function getShortDescriptionAttribute()
    {
        return Str::words($this->description, 50, '...');
    }

    public function users() {
        return $this->belongsTo(User::class);
    }
    
    public function eventtypes() {
        return $this->hasMany(EventType::class);
    }

    public function types() {
        $eventtypes = $this->eventtypes;
        $types = [];
        foreach ($eventtypes as $eventtype) {
            array_push($types, $eventtype->type);
        }
        return $types;
    }

    public function invitations() {
        return $this->hasMany(Invitation::class);
    }

    public function attendees() {
        return $this->hasMany(Attendee::class);
    }
}
