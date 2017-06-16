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
    /**
     * @var
     */
    protected $listing;

    /**
     * @var App\Common\EmojiHelper
     */
    protected $emojiHelper;

    /**
     * @var string
     */
    protected $item;

    /**
     * AddItemsConversation constructor.
     *
     * @param string $item
     */
    public function __construct($item) {
        $this->item = trim($item);
        $this->emojiHelper = resolve('App\Common\EmojiHelper');
    }

    public function setListing()
    {
        $this->listing = Listing::all();
    }

    protected function createNewListing()
    {
        $this->ask('Du hast noch keine Liste erstellt. Wie soll deine Liste heißen?', function (Answer $answer) {
            $listingName = $answer->getText();
            $this->listing = Listing::create(['name' => $listingName]);
            $this->say(sprintf('Ich habe eine neue Liste mit dem Namen %s erstellt. %s',
                    $listingName,
                    $this->emojiHelper->display(['ok hand', 'list']))
            );
            $this->ifItemExistsAttachItToListingOtherwiseCreateItFirst();
        });
    }

    protected function ifItemExistsAttachItToListingOtherwiseCreateItFirst() {
            if ($item = $this->itemIsAlreadyInDatabase()) {
                $this->attachItemToListing($item);

                return;
            }
            $this->chooseCategory();

            return;
        
    }

    /**
     * @return bool | Illuminate\Database\Eloquent\Model
     */
    protected function itemIsAlreadyInDatabase()
    {
        $newEntry = Item::where('name', $this->item)->first();
        if ($newEntry == null) {

            return false;
        }

        return $newEntry;
    }


    /**
     * @param Illuminate\Database\Eloquent\Model $item
     */
    protected function attachItemToListing($item)
    {
        $this->listing->addItem($item);
        $this->say(sprintf('%s wurde der Liste hinzugefuegt. %s',
                $this->item,
                $this->emojiHelper->display(['heavy check mark']))
        );
    }

    protected function chooseCategory()
    {
        $categoryButtons = $this->createArrayOfButtonsForAllCategories();
        $question = Question::create(sprintf('%s %s konnte  keiner Kategorie zu geordnet werden. Bitte waehle eine Kategorie aus.',
                $this->emojiHelper->display(['exclamation mark']),
                $this->item))
            ->fallback('unable to ask for category if item does not exist')
            ->callbackId('ask_for_category')
            ->addButtons($categoryButtons);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->saveItem($answer->getValue());
            }
        });
    }

    /**
     * @return array
     */
    protected function createArrayOfButtonsForAllCategories()
    {
        $categoryNames = [];
        $models = Category::all();
        foreach ($models as $model) {
            array_push($categoryNames, $model->name);
        }
        $categoryButtons = [];
        foreach ($categoryNames as $name) {
            array_push($categoryButtons, Button::create($name)->value($name));
        }

        return $categoryButtons;
    }

    /**
     * @param string $category
     */
    protected function saveItem($category)
    {
        $newItem = new Item(['name' => $this->item]);
        $category = Category::where('name', $category)->first();
        $newItem->category()->associate($category);
        $newItem->listing()->associate($this->listing);

        $newItem->save();

        $this->say(sprintf('%s wurde der Kategorie %s und der Liste %s hinzugefuegt. %s',
            $this->item,
            $category->name,
            $this->listing->name,
            $this->emojiHelper->display(['thumbs up sign']))
        );
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->setListing();
        if ($this->listing->isEmpty()) {
            $this->createNewListing();
        }
        else {
            $this->listing = $this->listing->first();
            $this->ifItemExistsAttachItToListingOtherwiseCreateItFirst();
        }
    }
}
