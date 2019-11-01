<?php

namespace App\Models;

use App\Traits\Eloquent\ModelHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use ModelHelper;

    /**
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        $table = $this->helper()->table(OrderProduct::class);

        return $this->belongsToMany(Product::class, $table)
            ->withPivot(['quantity', 'price']);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

}
