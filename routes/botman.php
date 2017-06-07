<?php
use App\Conversations\AddItemsConversation;
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

//$botman->hears('/start', BotmanController::class. '@startIntroductionConversation');

$botman->hears('s', BotManController::class.'@startConversation');

$botman->hears('/liste', BotManController::class. '@showListConversation');

$botman->hears('add {item}', function ($bot, $item) {
    $bot->startConversation(new AddItemsConversation($item));
});

//$botman->hears('/lists', BotmanController::class. '@showlistsConversation');

$botman->hears('/newlist', BotmanController::class. '@newListingConversation');
