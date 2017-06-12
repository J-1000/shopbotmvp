<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $guarded = [];

    public function items()
    {
    	return $this->hasMany(Item::class);
    }

    public function addItem($item)
    {
    	$this->items()->save($item);
    }
}
