<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Type;

class EventType extends Model
{
    /** @use HasFactory<\Database\Factories\EventTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'event_id',
        'type_id',
    ];
    
    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }
}
