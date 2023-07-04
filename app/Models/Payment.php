<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    protected $fillable =["amount", "code"];
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }
}
