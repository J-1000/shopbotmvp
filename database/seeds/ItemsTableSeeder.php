<?php

use Illuminate\Database\Seeder;
use App\Category;

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
            'wurst & fleisch' => [
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
            'obst & gemüse' => [
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
            ],
            'pasta & co' => [
                'nudeln', 'spaghetti', 'pesto', 'lasagneblätter'
            ],
            'konserven' => [
                'tomaten', 'saure gurken', 'fisch in der dose',
                'mais in der dose'
            ],
            'haushaltsartikel' => [
                'spüli', 'spülschwämme', 'klopapier', 'küchenrolle',
                'zahnpasta', 'waschmittel', 'spülmaschinentabs', 'müllbeutel'
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
