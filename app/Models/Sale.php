<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'sale_date',
        'rate_difference',
        'rate',
        'weight',
        'amount',
        'amount_paid',
        'arrears',
        'previous_arrears',
        'total_arrears',
        'sale_type',
        'description'
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }
}
