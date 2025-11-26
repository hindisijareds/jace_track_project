<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'delivered_at' => 'datetime',
        'payment_status' => 'string',
    ];

    protected $fillable = [
        'tracking_number',
        'customer_id',
        'rider_id',
        'status',
        'item_name',
        'item_type',
        'parcel_type',
        'parcel_weight',
        'dimension_l',
        'dimension_w',
        'dimension_h',
        'parcel_value',
        'sender_name',
        'sender_phone',
        'sender_address',
        'sender_detailed',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'receiver_detailed',
        'distance_km',
        'fuel_liters',
        'fuel_cost',
        'maintenance_cost',
        'box_size_cost',
        'box_weight_cost',
        'box_total_cost',
        'total_cost',
        'payment_status',
        'payment_method',
        'created_at',
        'delivered_at',
         'proof_of_delivery',
    'proof_status',
    'proof_image',
    'payment_proof_path',
    'payment_status',
    ];

    // Relationships
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }

    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // ✅ Accessors for Blade clarity
    public function getPickupAttribute()
    {
        return $this->sender_address;
    }

    public function getDropoffAttribute()
    {
        return $this->receiver_address;
    }
}
