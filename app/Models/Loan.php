<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = ["amount", "code", "duration", "processed", "repaid"];

    public function artist(): BelongsTo{
        return $this->belongsTo(Artist::class);
    }
}
