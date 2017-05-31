<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Listing;

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
