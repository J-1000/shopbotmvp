<?php

namespace App\Common;

class EmojiHelper
{
    protected $emojis = [
        'smiling face with open mouth' => '&#x1F603;',
        'thumbs up sign' => '&#x1f44d;',
        'winking face' => '&#x1F609;',
        'smiling face with smiling eyes' => '&#x1F60A;',
        'robot face' => '&#x1F916;',
        'weary cat face' => '&#x1F640;',
        'heavy check mark' => '&#x2714;',
        'face with stuck out tongue' => '&#x1F61C;',
        'ok hand' => '&#x1F44C;',
        'list' => '&#x1F4DD;',
        'red cross mark' => '&#x274C;',
        'double exclamation mark' => '&#x203C;',
    ];

    public function display(array $emojis)
    {
        $emojisDecoded = '';
        foreach ($emojis as $emoji) {
            $emojisDecoded .= html_entity_decode($this->emojis[$emoji], 0, 'UTF-8');
        }

        return $emojisDecoded;
    }
}
