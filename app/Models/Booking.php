<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'vehicle_id', 'driver_id', 'start_date', 'end_date', 'pickup_time',
        'pickup_location', 'dropoff_location', 'destination', 'total_KiloMeter',
        'total_amount', 'status', 'special_requests'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'pickup_time' => 'datetime:h:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}