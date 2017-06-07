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
    protected $listing;

    protected $item;

    public function __construct($item) {
        $this->item = trim($item);
    }

    public function checkForListings()
    {
        $this->listing = Listing::all();
        if ($this->listing->isEmpty()) {
            $this->ask('Du hast noch keine Liste erstellt. Wie soll deine Liste heißen?', function (Answer $answer) {
                $listingName = $answer->getText();
                $this->listing = Listing::create(['name' => $listingName]);
                $this->say('Ich habe eine neue Liste mit dem Namen ' . $listingName . ' erstellt.');

                if ($item = $this->itemIsAlreadyInDatabase()) {

                    $this->attachItemToListing($item);

                    return;
                };
                $this->chooseCategory();

                return;
            });
        }
        if ($this->listing->count() == 1) {
            $this->listing = $this->listing->first();
            if ($item = $this->itemIsAlreadyInDatabase()) {

                $this->attachItemToListing($item);

                return;
            };
            $this->chooseCategory();

            return;
        }

        // only to be used for multiple lists
        $buttons = [];
        foreach ($this->listing as $listing) {
            array_push($buttons, Button::create($listing->name)->value($listing->name));
            $question = Question::create('Zu welcher Liste moechtest Du Artikel hinzufuegen?')
                ->fallback('cannot add buttons')
                ->callbackId('adding_buttons')
                ->addButtons($buttons);
            $this->ask($question, function (Answer $answer) {
                $this->listing = $answer->getValue();

                if ($item = $this->itemIsAlreadyInDatabase()) {
                    $this->attachItemToListing($item);
                };
                $this->chooseCategory();
            });
        }
    }

    protected function itemIsAlreadyInDatabase()
    {
        $newEntry = Item::where('name', $this->item)->first();
        if ($newEntry == null) {
            return false;
        }

        return $newEntry;
    }

    protected function attachItemToListing($item)
    {
        $this->listing->addItem($item);
        $this->say($this->item . ' wurde der Liste hinzugefuegt');
    }

    protected function chooseCategory()
    {
        $categoryNames = [];
        $models = Category::all();
        // eventually replace with each->pluck->toArray
        foreach ($models as $model) {
            array_push($categoryNames, $model->name);
        }
        $categoryButtons = [];
        foreach ($categoryNames as $name) {
            array_push($categoryButtons, Button::create($name)->value($name));
        }
        $question = Question::create($this->item . ' konnte  keiner Kategorie zu geordnet werden. Bitte waehle eine Kategorie aus.')
            ->fallback('unable to ask for category if item does not exist')
            ->callbackId('ask_for_category')
            ->addButtons($categoryButtons);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->saveItem($answer->getValue());
            }
        });
    }

    protected function saveItem($category)
    {
        $newItem = new Item(['name' => $this->item]);
        $category = Category::where('name', $category)->first();
        $newItem->category()->associate($category);
        $newItem->listing()->associate($this->listing);

        $newItem->save();

        $this->say(sprintf('%s wurde der Kategorie %s und der Liste %s hinzugefuegt.',
            $this->item, $category->name, $this->listing->name)
        );
    }

    public function run()
    {
        $this->checkForListings();
    }
}
