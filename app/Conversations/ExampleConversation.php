<?php

namespace App\Conversations;

use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;
use App\Models\Category;

class ExampleConversation extends Conversation
{

    /**
     * First question
     */
    public function askReason()
    {

    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }

}
