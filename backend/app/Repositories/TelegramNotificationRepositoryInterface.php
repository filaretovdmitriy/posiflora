<?php

namespace App\Repositories;

use App\Models\Order;

interface TelegramNotificationRepositoryInterface
{
    public function notifyOrderCreated(Order $order): string;
}
