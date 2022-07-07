<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $casts = [
        'header' => 'array',
        'request' => 'array'
    ];
    use HasFactory;
    protected $guarded = ['id'];
}
