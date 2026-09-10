<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = ['prospect_id', 'type', 'notes'];

    // Relación: Un seguimiento pertenece a un único prospecto
    public function prospect(): BelongsTo
    {
        return $this->belongsTo(Prospect::class);
    }
}
