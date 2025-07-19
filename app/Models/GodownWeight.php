<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GodownWeight extends Model
{
    use HasFactory;

    protected $fillable = [
        'remaining_weight',
        'date',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'remaining_weight' => 'decimal:2',
    ];
}
