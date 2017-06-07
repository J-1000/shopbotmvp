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

    public function getListing()
    {
        $listing = Listing::first();
        // todo: sort items according to different supermarket layouts
        $items = $listing->items();
        $this->sortItems();
        $this->displayList($items);

    }

    protected function sortItems()
    {
        // todo
    }

    protected function displayList($items)
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
