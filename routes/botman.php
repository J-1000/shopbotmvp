<?php
use App\Conversations\AddItemsConversation;
use App\Conversations\ExampleConversation;
use App\Http\Controllers\BotManController;
use App\Listing;
use App\Item;

$botman = resolve('botman');

$botman->hears('/start', function ($bot) {
    $bot->reply('Hallo ' .
        $bot->getUser()->getFirstName() .
        '!! Gib die Artikel mit vorangestelltem + ein. Um die Liste anzuzeigen, gib das Kommando /liste ein. 
        Falls Du Hilfe brauchst -> /hilfe'
    );
});

$botman->hears('/liste', BotManController::class. '@showListConversation');

$botman->hears("\\+ {item}", function ($bot, $item) {
    $bot->startConversation(new AddItemsConversation($item));
});

$botman->hears("\\- {item}", function ($bot, $item) {
    $itemModel = Item::where('name', $item)->first();
    $listing = Listing::first();
    $itemModel->listing()->dissociate($listing);
    $itemModel->save();
    $bot->reply($item . ' wurde von der Liste entfernt.');
});

//$botman->hears('/neue liste', BotmanController::class. '@newListingConversation');

$botman->hears('/liste löschen', function ($bot) {
    $listing = Listing::first();
    $listing->delete();
    $bot->reply('Die Liste wurde gelöscht');
});

$botman->hears('/hilfe', function ($bot) {
    $bot->typesAndWaits(1);
    $bot->reply('Um einen Artikel der Liste hinzuzufügen, gib den Artikel mit vorangestelltem + ein.');
    $bot->typesAndWaits(1);
    $bot->reply('Ein vorangestelltes - entfernt den Artikel von der Liste');
    $bot->typesAndWaits(1);
    $bot->reply('Ein vorangestelltes - entfernt den Artikel von der Liste');
    $bot->typesAndWaits(1);
    $bot->reply('Gib / ein um eine Liste der Kommandos zu sehen.');
});
