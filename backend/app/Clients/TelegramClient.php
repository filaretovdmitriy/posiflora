<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;

class TelegramClient
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

     public function sendMessage(string $botToken, string $chatId, string $text): void
    {
        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text'    => $text,
        ]);
    }
    
}