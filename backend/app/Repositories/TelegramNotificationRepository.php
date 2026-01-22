<?php

namespace App\Repositories;

use App\Clients\TelegramClient;
use App\Models\Order;
use App\Models\TelegramIntegration;
use App\Models\TelegramSendLog;

class TelegramNotificationRepository implements TelegramNotificationRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private TelegramClient $telegramClient)
    {
    }

    public function notifyOrderCreated(Order $order): string
    {
        $shopId = $order->shop_id;

        $integration = TelegramIntegration::where('shop_id', $shopId)->first();

        if (! $integration || ! $integration->enabled) {
            return 'SKIPPED';
        }

        $exists = TelegramSendLog::where('shop_id', $shopId)
            ->where('order_id', $order->id)
            ->exists();

        if ($exists) {
            return 'SKIPPED';
        }

        $text = "Новый заказ {$order->number} на сумму {$order->total} ₽, клиент {$order->customer_name}";

        $status = 'SENT';
        $error  = null;

        try {
            $this->telegramClient->sendMessage(
                $integration->bot_token,
                $integration->chat_id,
                $text,
            );
        } catch (\Throwable $e) {
            $status = 'FAILED';
            $error  = $e->getMessage();
        }

        TelegramSendLog::create([
            'shop_id' => $shopId,
            'order_id' => $order->id,
            'message' => $text,
            'status'  => $status,
            'error'   => $error,
            'sent_at' => $status === 'SENT' ? now() : null,
        ]);

        return $status;
    }
}
