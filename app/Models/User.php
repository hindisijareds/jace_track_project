<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'password',
        'role',
        'profile_picture',
        'city',
        'barangay',
        'zip_code',
        'detailed_address',
        'contact_number',
        'info_locked',
        'phone_verified',
        'email_verified',
        'suspension_reason',
    'suspension_duration',
    'suspension_end_date',
    'suspension_message',
    'suspended_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'password' => 'hashed',
        'info_locked' => 'boolean',
        'phone_verified' => 'boolean',
        'email_verified' => 'boolean',
         'suspended_at' => 'datetime',
    'suspension_end_date' => 'date',
    ];

    /**
     * Use phone instead of email for login.
     */
    public function getAuthIdentifierName()
    {
        return 'phone';
    }

    /**
     * ✅ ADDED: Relationship for Riders.
     * This lets you do $user->shipments to see deliveries assigned to this rider.
     */
    public function shipments()
    {
        // Assuming 'rider_id' is the foreign key in the 'shipments' table
        return $this->hasMany(Shipment::class, 'rider_id');
    }
}