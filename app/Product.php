<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Laravel\Scout\Searchable;

class Product extends Model implements Buyable
{
    use Searchable;

    protected $with = ['user'];

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    /**
     * Get the identifier of the Buyable item.
     *
     * @param null $options
     * @return int|string
     */
    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    /**
     * Get the description or title of the Buyable item.
     *
     * @param null $options
     * @return string
     */
    public function getBuyableDescription($options = null)
    {
        return $this->name;
    }

    /**
     * Get the price of the Buyable item.
     *
     * @param null $options
     * @return float
     */
    public function getBuyablePrice($options = null)
    {
        return $this->price;
    }

    /**
     * Get the weight of the Buyable item.
     *
     * @param null $options
     * @return string
     */
    public function getBuyableWeight($options = null)
    {
        return 1;
    }

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        return array('id' => $array['id'], 'name' => $array['name'], 'description' => $array['description']);
    }
}
