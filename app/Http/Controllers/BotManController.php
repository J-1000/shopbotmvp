<?php

namespace App\Http\Controllers;

use App\Conversations\ExampleConversation;
use App\Conversations\AddItemsConversation;
use App\Conversations\ShowListConversation;;
use Mpociot\BotMan\BotMan;

class BotManController extends Controller
{
    public function handle()
    {
    	$botman = app('botman');
        $botman->verifyServices(env('TOKEN_VERIFY'));

        $botman->listen();
    }

    public function addItemsConversation(Botman $bot, $item)
    {
        $bot->startConversation(new AddItemsConversation($item));
    }

    public function showListConversation(Botman $bot)
    {
        $bot->startConversation(new ShowListConversation()); 
    }

}
