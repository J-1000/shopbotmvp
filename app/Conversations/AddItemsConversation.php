<?php

namespace App\Conversations;

use App\Models\Item;
use App\Models\Listing;
use App\Models\Category;
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

            $this->addItemsToListing($this->listings->first());

            return;
        }
        $buttons = [];
        foreach ($this->listings as $listing) {
            array_push($buttons, Button::create($listing->name)->value($listing->name));
            $question = Question::create('Zu welcher Liste moechtest Du Artikel hinzufuegen?')
                ->fallback('cannot add buttons')
                ->callbackId('adding_buttons    ')
                ->addButtons($buttons);
            $this->ask($question, function (Answer $answer) {

                $this->addItemsToListing($this->listings->where('name', $answer->getValue())->first());
            });
        }
    }

    protected function addItemsToListing($listing)
    {
        $this->bot->typesAndWaits(1);
        $this->say('Ok, wir fuegen Artikel der Liste ' . $listing->name . ' hinzu');
        $this->bot->typesAndWaits(1);
        $question = 'Bitte gib die Artikel durch Komma getrennt ein';
        $this->ask($question, function (Answer $answer) use($listing){
            $items = explode(',', $answer->getText());

            $this->saveItems($items, $listing);
        });
    }

    protected function chooseCategory($newEntry, $item, $listing)
    {

        if ($newEntry == null) {
            $categoryNames = [];
            $models = Category::all();
            foreach($models as $model) {
                array_push($categoryNames, $model->name);
            }
            $categoryButtons = [];
            foreach ($categoryNames as $name) {
                array_push($categoryButtons, Button::create($name)->value($name));
            }
            $question = Question::create($item  .' konnte  keiner Kategorie zu geordnet werden. Bitte waehle eine Kategorie aus.')
                ->fallback('unable to ask for category if item does not exist')
                ->callbackId('ask_for_category')
                ->addButtons($categoryButtons);
            $this->ask($question, function (Answer $answer) use ($item, $listing){
                if ($answer->isInteractiveMessageReply()) {
                    $newItem = new Item(['name' => $item]);
                    $category =Category::where('name', $answer->getValue())->first();
                    //$category->addItem(['name' => $item]);    this works
                    //$listing->addItem($newItem);
                    $newItem->category()->associate($category);
                    $newItem->listing()->associate($listing);
                    $newItem->save();
                }
            });
        }
    }

    protected function saveItems($items, $listing)
    {
        foreach ($items as $item) {
            $newEntry = Item::where('name', trim($item))->first();
            $listing->addItem($newEntry);
            $this->say($item . ' wurde der Liste hinzugefuegt.');
        }
    }

    public function run()
    {
        $this->checkForListings();
    }
}
