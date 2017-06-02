<?php

namespace App\Conversations;

use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;

class NewListingConversation extends Conversation
{

    /**
     * First question
     */
    public function askForListingName()
    {
        $question = 'Ok' . $this->bot->getUser()->getFirstName() . ', wie soll ich die neue Liste nennen?';
        $this->ask($question, function(Answer $answer) {
            $listingName = $answer->getText();
            Listing::create(['name' => $listingName]);
            $this->say('Ich habe eine Liste mit dem Namen ' . $listingName . ' erstellt');
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askForListingName();
    }
}
