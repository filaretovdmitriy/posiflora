<?php

namespace App\Repositories;

use App\Clients\TelegramClient;
use App\Models\TelegramIntegration;

class TelegramIntegrationRepository implements TelegramIntegrationRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private TelegramClient $telegramClient)
    {
        //
    }

    public function upsertForShop(int $shopId, array $data): TelegramIntegration
    {
        return TelegramIntegration::updateOrCreate(
            ['shop_id' => $shopId],
            [
                'bot_token' => $data['botToken'],
                'chat_id'   => $data['chatId'],
                'enabled'   => $data['enabled'],
            ],
        );
    }
}
