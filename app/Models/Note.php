<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user',
        'text',
        'day',
        'bookmated',
        'theday',
    ];
    
    use HasFactory;
}
