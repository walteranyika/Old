<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    use HasFactory;

    public $table = 'trackers';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'session_id',
        'phone',
        'created_at',
        'updated_at'
    ];


}
