<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Order extends Model
{
    use EloquentSoftDeletes, LogsActivity;

    

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'customer_email',
        'order_amount',
    ];

    protected $casts = [
        'order_amount' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //->logOnly(['customer_name', 'customer_email', 'order_amount'])
            ->setDescriptionForEvent(fn(string $eventName) =>
                'Order ' . $eventName . ' for customer: ' . $this->customer_name . '.' .
                ($this->wasChanged('customer_name') ? ' Old name: ' . $this->getOriginal('customer_name') . ' New name: ' . $this->customer_name : '') .
                ($this->wasChanged('order_amount')
                    ? ' Old amount:$' . $this->getOriginal('order_amount') . ' New amount: $' . $this->order_amount
                    : '')
                . ($this->wasChanged('customer_email') ? ' Old email: ' . $this->getOriginal('customer_email') . ' New email: ' . $this->customer_email : '')
            );
    }
}
