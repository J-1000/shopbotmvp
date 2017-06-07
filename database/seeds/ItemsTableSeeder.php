<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$models = [
            'wurst und fleisch' => [
                'lyoner', 'salami', 'wiener', 'leberwurst'
            ],
            'backwaren' => [
                'brot', 'brötchen', 'aufbackbrötchen'
            ],
            'milchprodukte' => [
                'appenzeller', 'käse', 'frischkäse', 'babybel', 'quark', 
                'milch', 'joghurt', 'sahne', 'schlagsahne', 'saure sahne', 
            ],
            'kaffe & co' => [
                'kaffee', 'tee'
            ],
            'obst und gemüse' => [
                'tomaten', 'biotomaten', 'blumenkohl', 'äpfel', 'orangen', 
                'bananen', 'salat', 'birnen', 'brokkoli', 'karotten', 'möhren', 
                'zwiebeln', 'lauchzwiebeln', 'kartoffeln', 'bohnen', 'gurke', 'salatgurke',
				'pilze' 	

            ],
            'kühlregal' => [
                'tortellini', 'dillhappen', 'pizzateig'
            ],
            'tiefkühlwaren' => [
                'garnelen', 'tiefkühlpizza'
            ],
            'süßwaren & knabberzeug' => [
                'chips', 'schokolade', 'schokobons', 'erdnüsse'
            ]
        ]; 

        foreach ($models as $key => $value) {
	    	$category = Category::where('name', $key)->first();
	    	foreach ($value as $item) {
	    		$category->addItem(['name' => $item]);
	    	}
        }
    }
}
