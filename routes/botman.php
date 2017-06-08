<?php
use App\Conversations\AddItemsConversation;
use App\Conversations\ExampleConversation;
use App\Http\Controllers\BotManController;
use App\Listing;

$botman = resolve('botman');

$botman->hears('/start', function ($bot) {
    $bot->reply('Hallo ' . $bot->getUser()->getFirstName() .  '!! Gib die Artikel mit vorangestelltem + ein. Um die Liste anzuzeigen, gib das Kommando /liste ein');
});

$botman->hears('s', function ($bot) {
    $bot->startConversation(new ExampleConversation());
});

$botman->hears('/Liste', BotManController::class. '@showListConversation');

$botman->hears("\\+ {item}", function ($bot, $item) {
    $bot->startConversation(new AddItemsConversation($item));
});

$botman->hears('/newlist', BotmanController::class. '@newListingConversation');

$botman->hears('/Liste löschen', function ($bot) {
    $listing = Listing::first();
    $listing->delete();
    $bot->reply('Die Liste wurde gelöscht');
});

