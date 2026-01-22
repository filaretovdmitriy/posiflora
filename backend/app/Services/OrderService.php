<?php

namespace App\Services;

use App\DTOs\OrderCreateData;
use App\Models\Order;
use App\Models\Shop;
use App\Repositories\TelegramNotificationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private TelegramNotificationRepositoryInterface $telegramNotifications,
    ) {}

    public function orderCreate(int $shopId, OrderCreateData $data): array
    {
        return DB::transaction(function () use ($shopId, $data) {
            $shop = Shop::findOrFail($shopId);

            $order = $shop->orders()->create([
                'number'        => $data->number,
                'total'         => $data->total,
                'customer_name' => $data->customerName,
            ]);

            $status = $this->telegramNotifications->notifyOrderCreated($order);

            return [
                'order'  => $order,
                'status' => $status,
            ];
        });
    }
}