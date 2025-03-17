<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'shipping_method',
        'shipping_cost',
        'notes',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    }
}
