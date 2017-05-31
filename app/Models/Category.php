<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function getRouteByKeyName()
    {
    	
    }

    public function items()
    {
    	return $this->hasMany(Item::class);	
    }

    public function addItem($item)
    {
    	$this->items()->create($item);	
    }

}
