<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Animation;


class Game
{
    use Concerns\Data;

    public function __construct(
        /** @var string Title of the game */
        public string $title,
        
        /** @var string Description of the game */
        public string $description,
        
        /** @var array<\MemoGram\Api\Types\PhotoSize> Photo that will be displayed in the game message in chats. */
        public array $photo,
        
        /** @var string|null Optional. Brief description of the game or high scores included in the game message. Can be automatically edited to include current high scores for the game when the bot calls setGameScore, or manually edited using editMessageText. 0-4096 characters. */
        public null|string $text = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. Special entities that appear in text, such as usernames, URLs, bot commands, etc. */
        public null|array $text_entities = null,
        
        /** @var Animation|null Optional. Animation that will be displayed in the game message in chats. Upload via BotFather */
        public null|Animation $animation = null,
        
        
    ) { }
}
