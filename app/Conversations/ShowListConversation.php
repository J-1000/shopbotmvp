<?php

namespace App\Conversations;

use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;
use Mpociot\BotMan\Message;
use App\Models\Item;
use App\Models\Listing;

class ShowListConversation extends Conversation
{

    public function selectListing()
    {
        $listings = Listing::all();
        if ($listings->count() == 1) {

            // todo: sort items according to different supermarket layouts
            $items = $listings->items();
            $this->displayItems($items);
        }
    }

    protected function displayItems($items)
    {
        $list = 'Hier ist deine Liste:' . "\n\n";
        foreach ($items as $item) {
            $list .= $item->name . "\n";
        }

        $this->say($list);
    }

    public function run()
    {
       $this->selectListing();
    }
}
