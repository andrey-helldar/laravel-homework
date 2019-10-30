<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Partner
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Partner extends Model
{
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
