<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'customer_email',
        'order_amount',
    ];

    protected $casts = [
        'order_amount' => 'integer',
    ];
}
