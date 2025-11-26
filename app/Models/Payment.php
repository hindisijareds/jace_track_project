<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'payment_status',
        'payment_date',
    ];

    // ✅ Link back to Shipment
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'order_id', 'order_id');
    }
}
