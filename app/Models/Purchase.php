<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_date',
        'supplier_id',
        'driver_name',
        'vehicle_number',
        'load_weight',
        'net_weight',
        'short_weight',
        'rate_difference',
        'rate',
        'amount',
        'paid',
        'godown',
        'description'
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
