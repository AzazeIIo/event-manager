<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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

    public function getShortDescriptionAttribute()
    {
        return Str::words($this->description, 50, '...');
    }

    public function getType($value)
    {
        switch($value) {
            case 1:
                return 'Art and culture';
                break;
            case 2:
                return 'Charity';
                break;
            case 3:
                return 'Conference';
                break;
            case 4:
                return 'Educational';
                break;
            case 5:
                return 'Festival';
                break;
            case 6:
                return 'Social';
                break;
            case 7:
                return 'Sport';
                break;
            case 8:
                return 'Virtual';
                break;
            case 9:
                return 'Workshop';
                break;
            default:
                return 'error';    
        }
    }

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
