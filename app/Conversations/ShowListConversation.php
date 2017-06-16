<?php

namespace App\Conversations;

use Illuminate\Support\Facades\DB;
use Mpociot\BotMan\Conversation;
use App\Models\Listing;

class ShowListConversation extends Conversation
{
    /**
     * @var App\Common\EmojiHelper
     */
    protected $emojiHelper;

    /**
     * ShowListConversation constructor.
     */
    public function __construct() {
        $this->emojiHelper = resolve('App\Common\EmojiHelper');
    }

    /**
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getItems()
    {
        $listingId = Listing::first()->id;
        $items = DB::table('items')->where('listing_id', $listingId)->get();

        return $items;
    }

    /**
     * @param Illuminate\Database\Eloquent\Collection $items
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    protected function sortItems($items)
    {
        $ids = [4, 8, 12, 2, 6, 1, 3, 10, 9, 11, 5, 7];

        $sorted = $items->sortBy(function($model) use ($ids) {
            return array_search($model->category_id, $ids);
        });

        return $sorted;
    }

    /**
     * @param Illuminate\Database\Eloquent\Collection $items
     */
    protected function displayListing($items)
    {
        $list = 'Hier ist deine Liste:' . "\n\n" . $this->emojiHelper->display(['list']) . "\n\n";
        foreach ($items as $item) {
            $list .= $item->name . "\n";
        }

        $this->say($list);
    }

    /**
     * Run the conversation
     */
    public function run()
    {
        $items = $this->getItems();
        $sortedItems = $this->sortItems($items);
        $this->displayListing($sortedItems);
    }
}
