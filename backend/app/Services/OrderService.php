<?php

namespace App\Services;

use App\Clients\TelegramClient;
use App\DTOs\OrderCreateData;
use App\Models\Order;
use App\Models\Shop;
use App\Models\TelegramIntegration;
use App\Models\TelegramSendLog;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private TelegramClient $telegramClient)
    {
        //
    }

       public function orderCreate(int $shopId, OrderCreateData $data): array
    {
        return DB::transaction(function () use ($shopId, $data) {
           
            $shop = Shop::findOrFail($shopId);

            $order = $shop->orders()->create([
                'number'        => $data->number,
                'total'         => $data->total,
                'customer_name' => $data->customerName,
            ]);

            $integration = TelegramIntegration::where('shop_id', $shopId)->first();

            if (! $integration || ! $integration->enabled) {
                return $order;
            }

          
            $exists = TelegramSendLog::where('shop_id', $shopId)
                ->where('order_id', $order->id)
                ->exists();

            if ($exists) {
                return $order;
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
                'order_id'=> $order->id,
                'message' => $text,
                'status'  => $status,
                'error'   => $error,
                'sent_at' => $status === 'SENT' ? now() : null,
            ]);

            return [
                'order'  => $order,
                'status' => $status,
            ];
        });
    }
}