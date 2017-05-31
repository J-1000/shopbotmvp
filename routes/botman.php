<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('/start', function($bot){
    $bot->reply('hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('/list', BotManController::class. '@showListConversation');

$botman->hears('add', BotManController::class. '@addItemsConversation');
