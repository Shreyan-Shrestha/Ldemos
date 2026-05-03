<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Order extends Model
{
    use LogsActivity;
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
