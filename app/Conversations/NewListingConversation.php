<?php

namespace App\Conversations;

use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Conversation;

class NewListingConversation extends Conversation
{
    public function createNewListing()
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
        $this->createNewListing();
    }
}
