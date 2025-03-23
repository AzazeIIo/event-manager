<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Event;

class Attendee extends Model
{
    /** @use HasFactory<\Database\Factories\AttendeesFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function events() {
        return $this->belongsTo(Event::class);
    }
}
