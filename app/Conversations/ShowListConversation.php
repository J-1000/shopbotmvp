<?php

namespace App\Conversations;

use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;
use Mpociot\BotMan\Message;
use App\Models\Item;

class ShowListConversation extends Conversation
{

    public function displayList()
    {
        $items = Item::all();
        $list = 'Hier ist deine Liste:' . "\n\n";
        if ($items->isEmpty()) {
            $this->say('Du hast noch keine Artikel hinzugefügt');
        }
        foreach ($items as $item) {
            $list .= $item->name . "\n";
        }

        $this->say($list);

    }

    public function run()
    {
       $this->displayList();
    }
}
