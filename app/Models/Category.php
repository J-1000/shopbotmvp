<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function items()
    {
    	return $this->hasMany(Item::class);	
    }

    public function addItem($item)
    {
    	$this->items()->create($item);	
    }

    public function attachItem($item)
    {
        $this->items()->save($item);
    }
}
