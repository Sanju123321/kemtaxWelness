<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOrderItem extends Model
{
    protected $fillable = [
        'product_order_id',
        'product_id',
        'product_name',
        'sku',
        'price',
        'quantity',
        'line_total',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'line_total' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(ProductOrder::class, 'product_order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
