<?php
use App\Conversations\AddItemsConversation;
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('/start', function ($bot) {
    $bot->reply('Hallo ' . $bot->getUser()->getFirstName() .  '!! Gib die Artikel mit vorangestelltem + ein. Um die Liste anzuzeigen, gib das Kommando /liste ein');
});

$botman->hears('s', BotManController::class.'@startConversation');

$botman->hears('/liste', BotManController::class. '@showListConversation');

$botman->hears("\\+ {item}", function ($bot, $item) {
    $bot->startConversation(new AddItemsConversation($item));
});

$botman->hears('/newlist', BotmanController::class. '@newListingConversation');
