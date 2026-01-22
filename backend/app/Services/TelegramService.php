<?php

namespace App\Services;

use App\Clients\TelegramClient;
use App\DTOs\TelegramConnectData;
use App\Models\TelegramIntegration;
use App\Models\TelegramSendLog;
use App\Repositories\TelegramIntegrationRepositoryInterface;

class TelegramService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private TelegramIntegrationRepositoryInterface $telegramIntegrations,
        private TelegramClient $telegramClient
    ) {
        //
    }

    public function connect(String $shopId, TelegramConnectData $data): TelegramIntegration
    {
        return $this->telegramIntegrations->upsertForShop($shopId, $data->toArray());
    }



    public function getStatus(int $shopId): array
    {
        $integration = TelegramIntegration::where('shop_id', $shopId)->first();

        if (! $integration) {
            return [
                'enabled'      => false,
                'chatId'       => null,
                'lastSentAt'   => null,
                'sentCount'    => 0,
                'failedCount'  => 0,
            ];
        }

        $chatIdMasked = $this->maskChatId($integration->chat_id);

        $from = now()->subDays(7);

        $sentCount = TelegramSendLog::where('shop_id', $shopId)
            ->where('status', 'SENT')
            ->where('sent_at', '>=', $from)
            ->count();

        $failedCount = TelegramSendLog::where('shop_id', $shopId)
            ->where('status', 'FAILED')
            ->where('sent_at', '>=', $from)
            ->count();

        $lastSentAt = TelegramSendLog::where('shop_id', $shopId)
            ->whereNotNull('sent_at')
            ->orderByDesc('sent_at')
            ->value('sent_at');

        return [
            'enabled'     => $integration->enabled,
            'chatId'      => $chatIdMasked,
            'lastSentAt'  => $lastSentAt,
            'sentCount'   => $sentCount,
            'failedCount' => $failedCount,
        ];
    }

    private function maskChatId(string $chatId): string
    {
        $len = mb_strlen($chatId);

        if ($len <= 4) {
            return str_repeat('*', max($len - 1, 0)) . mb_substr($chatId, -1);
        }

        return str_repeat('*', $len - 4) . mb_substr($chatId, -4);
    }
}
