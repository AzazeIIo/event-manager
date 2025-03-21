<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /** @use HasFactory<\Database\Factories\InvitationsFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
    ];
}
