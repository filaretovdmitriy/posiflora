<?php

namespace App\Repositories;

use App\Models\TelegramIntegration;

interface TelegramNotificationRepositoryInterface
{
    public function upsertForShop(int $shopId, array $data): TelegramIntegration;
}
