<?php

namespace App\Conversations;

class TestConversation
{
    public function displayList()
    {
        $items = Item::all();
        $buttons = [];
        foreach ($items as $item) {
            array_push($buttons, Button::create($item->name)->value($item->id));
        }
        $question = Question::create('Hier ist die Liste. Um einen Artikel zu entfernen, drueck ihn einfach.')
            ->fallback('Unable to show items')
            ->callbackId('show_items')
            ->addButtons($buttons);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                Item::destroy($answer->getValue());
                $this->displayList();
            }
        });
    }
}
