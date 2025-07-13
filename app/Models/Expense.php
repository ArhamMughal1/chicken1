<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'date',
        'category',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Common expense categories - you can customize these
    public static function categories()
    {
        return [
            'Food' => 'Food',
            'Fuel' => 'Fuel',
            'Workshop' => 'Workshop',
            'Salary' => 'Salary',
            'Transportation' => 'Transportation',
            'Housing' => 'Housing',
            'Entertainment' => 'Entertainment',
            'Utilities' => 'Utilities',
            'Healthcare' => 'Healthcare',
            'Shopping' => 'Shopping',
            'Education' => 'Education',
            'Other' => 'Other',
        ];
    }
}
