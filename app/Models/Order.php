<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'ig_username',
        'country',
        'has_custom_logo',
        'payment_method',
        'terms_accepted',
        'total_price',
        'status',
        'order_date',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
