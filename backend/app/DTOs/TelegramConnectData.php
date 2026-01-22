<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class TelegramConnectData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $botToken,
        public string $chatId,
        public bool $enabled
    ) {
        //
    }
}
