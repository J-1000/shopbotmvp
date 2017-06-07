<?php

namespace App\Conversations;

use Illuminate\Support\Facades\DB;
use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;
use Mpociot\BotMan\Message;
use App\Item;
use App\Listing;
use App\Category;

class ShowListConversation extends Conversation
{

    public function getListing()
    {
        $listingId = Listing::first()->id;
        $items = DB::table('items')->where('listing_id', $listingId)->get();
        $this->displayList($items);
    }

    protected function sortItems($items)
    {

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
       $this->getListing();
    }
}
