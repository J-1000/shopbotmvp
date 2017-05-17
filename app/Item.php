<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Listing;

class Item extends Model
{
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
