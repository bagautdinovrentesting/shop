<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @property float $price
 * @property int $id
 * @property string $name
*/

class Product extends Model implements Buyable
{
    use Searchable;

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo('App\Section');
    }

    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    public function getBuyableDescription($options = null): string
    {
        return $this->name;
    }

    public function getBuyablePrice($options = null): float
    {
        return $this->price;
    }

    public function getBuyableWeight($options = null): int
    {
        return 1;
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        return array('id' => $array['id'], 'name' => $array['name'], 'description' => $array['description']);
    }

    public function getUpdatedAtAttribute(string $value): string
    {
        return (new Carbon($value))->format('d.m.Y H:i:s');
    }

    public function values(): BelongsToMany
    {
        return $this->belongsToMany('App\PropertyValue', 'property_value_product');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany('App\Review');
    }

    public function getProperties(): array
    {
        $productProperties = [];

        foreach ($this->values as $value) {
            $productProperties[$value->property->id] = $value->id;
        }

        return $productProperties;
    }
}
