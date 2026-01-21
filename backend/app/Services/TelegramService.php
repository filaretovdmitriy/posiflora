<?php

namespace App\Services;

use App\Clients\TelegramClient;
use App\DTOs\TelegramConnectData;
use App\Models\TelegramIntegration;
use App\Repositories\TelegramIntegrationRepositoryInterface;
use App\Repositories\TelegramRepositorie;

class TelegramService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private TelegramIntegrationRepositoryInterface $telegramIntegrations,
        private TelegramClient $telegramClient
    )
    {
        //
    }

    public function connect(String $shopId,TelegramConnectData $data): TelegramIntegration {
      return $this->telegramIntegrations->upsertForShop($shopId, $data->toArray());
    }

    public function notifyOrderCreated(): void
    {
       

        $text = "Новый заказ {number} на сумму {total} ₽, клиент
{customerName}";
        $bot_token="";
        $chat_id="";

        $this->telegramClient->sendMessage(
            $bot_token,
            $chat_id,
            $text,
        );

     
    }
}