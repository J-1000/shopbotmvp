<?php

namespace App\Conversations;

use App\Item;
use Illuminate\Foundation\Inspiring;
use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;

class AddItemsConversation extends Conversation
{
    public function askForItems()
    {
        // $question = 'Bitte gib die Artikel mit Leerzeichen ein';
        // $this->ask($question, function(Answer $answer) {
        //     $items = explode(' ', $answer->getText());
        //     foreach ($items as $item) {
        //         // define category 
        //         Item::create(['name' => $item]);
        //         $this->bot->typesAndWaits(2);
        //         $this->say('Ich habe ' . $item . ' der Liste hinzugefuegt.');
        //     }

            
        // });
        $question = 'Bitte gib die Artikel mit Komma getrennt ein.';
        $this->ask($question, function(Answer $answer) {
            $items = explode(',', $answer->getText());
            
        }
    }

    public function run()
    {
        $this->askForItems();
    }
}
