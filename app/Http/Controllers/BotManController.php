<?php

namespace App\Http\Controllers;

use App\Conversations\ExampleConversation;
use App\Conversations\AddItemsConversation;
use App\Conversations\ShowListingConversation;;
use Mpociot\BotMan\BotMan;

class BotManController extends Controller
{
    /**
     * Handle the conversation
     */
    public function handle()
    {
    	$botman = app('botman');
        $botman->verifyServices(env('TOKEN_VERIFY'));

        $botman->listen();
    }

    /**
     * @param \Mpociot\BotMan\BotMan $bot
     * @param string $item
     */
    public function addItemsConversation(Botman $bot, $item)
    {
        $bot->startConversation(new AddItemsConversation($item));
    }

    /**
     * Loaded through routes/botman.php
     * @param \Mpociot\BotMan\BotMan $bot
     */
    public function showListingConversation(Botman $bot)
    {
        $bot->startConversation(new ShowListingConversation());
    }
}
