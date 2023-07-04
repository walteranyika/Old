<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountLimit extends Model
{
    use HasFactory;
    protected $fillable = ["royalties","advance_limit"];
}
