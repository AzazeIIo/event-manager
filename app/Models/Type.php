<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventType;

class Type extends Model
{
    protected $fillable = [
        'type_name',
    ];

    public function eventtypes() {
        return $this->hasMany(EventType::class);
    }
}
