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
    		'wurst und fleisch', 'backwaren', 'michprodukte', 
    		'kaffe & co', 'obst und gemüse', 'kühlregal',
    		'tiefkühlwaren', 'süßwaren & knabberzeug'
    	];
    	foreach ($categories as $category) {
    		Category::create([
    			'name' => $category
    		]);
    	}
    }
}
