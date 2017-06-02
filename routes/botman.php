<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

//$botman->hears('/start', BotmanController::class. '@startIntroductionConversation');

$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('/list', BotManController::class. '@showListConversation');

$botman->hears('/add', BotManController::class. '@addItemsConversation');

//$botman->hears('/lists', BotmanController::class. '@showlistsConversation');

$botman->hears('/newlist', BotmanController::class. '@newListingConversation');
