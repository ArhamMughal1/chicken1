<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightShortage extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'date',
        'shortage_amount',
        'details'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
