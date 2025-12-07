<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $fillable = [
        'tracking_no',
        'customer_name',
        'storage_no',
        'delivery_date',
        'pickup_date',
        'status',
    ];
}
