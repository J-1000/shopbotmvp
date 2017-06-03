<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
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
//                    $categoryNames = Category::all()->each(function ($category) {
//                        $category->pluck('name');
//                    })->toArray();
                    $c = Category::where('name', 'backwaren')->first();
                    $this->say($c->name);

//                    foreach ($categoryNames as $name) {
//                        array_push($categoryButtons, Button::create($name)->value($name));
//                    }
//                    $question = Question::create('Der Artikel konnte  keiner Kategorie zu geordnet werden. Bitte waehle eine Kategorie aus.')
//                        ->fallback('unable to ask for category if item does not exist')
//                        ->callbackId('ask_for_category')
//                        ->addButtons($categoryButtons);
//                    $this->ask($question, function (Answer $answer) {
//                        if ($answer->isInteractiveMessageReply()) {
//
//                        }
//                    });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }

}
