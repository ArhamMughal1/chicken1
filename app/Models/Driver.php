<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details'
    ];

    public function weightShortages()
    {
        return $this->hasMany(WeightShortage::class);
    }
}
