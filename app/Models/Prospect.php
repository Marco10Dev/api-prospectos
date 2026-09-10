<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prospect extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
    ];


    protected $attributes = [
        'status' => 'new',
    ];

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }
}
