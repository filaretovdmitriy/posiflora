<?php

namespace App\Repositories;

use App\Models\TelegramIntegration;

interface TelegramIntegrationRepositoryInterface
{
    public function upsertForShop(int $shopId, array $data): TelegramIntegration;
}