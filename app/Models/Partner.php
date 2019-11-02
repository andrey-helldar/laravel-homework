<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Partner
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @method static Builder|Partner newModelQuery()
 * @method static Builder|Partner newQuery()
 * @method static Builder|Partner query()
 * @method static Builder|Partner whereCreatedAt($value)
 * @method static Builder|Partner whereEmail($value)
 * @method static Builder|Partner whereId($value)
 * @method static Builder|Partner whereName($value)
 * @method static Builder|Partner whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Partner extends Model
{
    protected $fillable = ['email', 'name'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
