<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventType;

class Type extends Model
{
    protected $fillable = [
        'type_name',
    ];

    public function types() {
        return $this->hasMany(EventType::class);
    }
}
