<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $primaryKey = 'name';

    protected $guarded = [];

    public function category()
    {
  		return $this->belongsTo(Category::class);  	
    }

    public function listing()
    {
    	return $this->belongsTo(Listing::class);
    }
}
