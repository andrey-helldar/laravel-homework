<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Vendor
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vendor extends Model
{
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
