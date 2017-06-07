<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = [
    		'wurst & fleisch', 'backwaren', 'milchprodukte',
    		'kaffe & co', 'obst & gemüse', 'kühlregal',
    		'tiefkühlwaren', 'süßwaren & knabberzeug', 'pasta & co',
            'konserven', 'haushaltsartikel'
    	];
    	foreach ($categories as $category) {
    		Category::create([
    			'name' => $category
    		]);
    	}
    }
}
