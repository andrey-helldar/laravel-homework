<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'client_email', 'partner_id', 'delivery_at'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->orderBy('name')
            ->withPivot(['quantity', 'price']);
    }

    public function pivotProduct(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
