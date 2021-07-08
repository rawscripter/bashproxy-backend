<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_price',
        'currency',
        'paid_amount',
        'discount_code',
        'discount_amount',
        'status',
        'is_paid',
        'quantity',
        'customer_email',
        'customer_id',
        'discount_amount',
        'is_quota_added',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
