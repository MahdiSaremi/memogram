<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Poll
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique poll identifier */
        public string $id,
        
        /** @var string Poll question, 1-300 characters */
        public string $question,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. Special entities that appear in the question. Currently, only custom emoji entities are allowed in poll questions */
        public null|array $question_entities = null,
        
        /** @var array<\MemoGram\Api\Types\PollOption> List of poll options */
        public array $options,
        
        /** @var int Total number of users that voted in the poll */
        public int $total_voter_count,
        
        /** @var bool True, if the poll is closed */
        public bool $is_closed,
        
        /** @var bool True, if the poll is anonymous */
        public bool $is_anonymous,
        
        /** @var string Poll type, currently can be “regular” or “quiz” */
        public string $type,
        
        /** @var bool True, if the poll allows multiple answers */
        public bool $allows_multiple_answers,
        
        /** @var int|null Optional. 0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot. */
        public null|int $correct_option_id = null,
        
        /** @var string|null Optional. Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters */
        public null|string $explanation = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. Special entities like usernames, URLs, bot commands, etc. that appear in the explanation */
        public null|array $explanation_entities = null,
        
        /** @var int|null Optional. Amount of time in seconds the poll will be active after creation */
        public null|int $open_period = null,
        
        /** @var int|null Optional. Point in time (Unix timestamp) when the poll will be automatically closed */
        public null|int $close_date = null,
        
        
    ) { }
}
