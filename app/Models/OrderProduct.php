<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];
}
