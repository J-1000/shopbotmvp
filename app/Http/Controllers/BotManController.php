<?php

namespace App\Http\Controllers;

use App\Conversations\ExampleConversation;
use App\Conversations\AddItemsConversation;
use App\Conversations\ShowListConversation;;
use Illuminate\Http\Request;
use Mpociot\BotMan\BotMan;

class BotManController extends Controller
{
	/**
	 * Place your BotMan logic here.
	 */
    public function handle()
    {
    	$botman = app('botman');
        $botman->verifyServices(env('TOKEN_VERIFY'));

        $botman->listen();
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }

    public function addItemsConversation(Botman $bot)
    {
        $bot->startConversation(new AddItemsConversation());
    }

    public function showListConversation(Botman $bot)
    {
        $bot->startConversation(new ShowListConversation()); 
    }

}
