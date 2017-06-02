<?php

namespace App\Conversations;

use App\Models\Item;
use App\Models\Listing;
use Illuminate\Foundation\Inspiring;
use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;

class AddItemsConversation extends Conversation
{
    protected $listings;

    public function checkForListings()
    {
        $this->listings = Listing::all();
        if ($this->listings->isEmpty()) {
            $this->ask('Du hast noch keine Liste erstellt. Wie soll deine Liste heißen?', function (Answer $answer) {
                $listingName = $answer->getText();
                $this->listings = Listing::create(['name' => $listingName]);
                $this->say('Ich habe eine neue Liste mit dem Namen ' . $listingName . ' erstellt.');
                $this->addItemsToListing($this->listings);

                return;
            });

        }
        if ($this->listings->count() == 1) {
            $this->addItemsToListing($this->listings);

            return;
        }
        $buttons = [];
        foreach ($this->listings as $listing) {
            array_push($buttons, Button::create($listing->name)->value($listing->name));
            $question = Question::create('Zu welcher Liste moechtest Du Artikel hinzufuegen?')
                ->addButtons($buttons);
            $this->ask($question, function (Answer $answer) {
                 $this->addItemsToListing($answer->getText());
            });
        }
    }

    protected function addItemsToListing($listing)
    {
        $this->bot->typesAndWaits(3);
        $this->say('Ok, wir fuegen Artikel der Liste ' . $listing->name . ' hinzu');
        $this->bot->typesAndWaits(3);
        $question = 'Bitte gib die Artikel durch Komma getrennt ein';
        $this->ask($question, function (Answer $answer) use($listing){
            $items = explode(',', $answer->getText());
            foreach ($items as $item) {
                $listing->addItem($item);
                $this->bot->typesAndWaits(1);
                $this->say('Ich habe ' . $item . ' der Liste hinzugefuegt.');
            }
        });
    }

    public function run()
    {
        $this->checkForListings();
    }
}
