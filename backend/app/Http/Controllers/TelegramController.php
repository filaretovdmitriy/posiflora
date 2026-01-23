<?php

namespace App\Http\Controllers;

use App\DTOs\TelegramConnectData;
use App\Http\Requests\TelegramRequest;
use App\Http\Resources\TelegramStatusResource;
use App\Services\TelegramService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class TelegramController extends Controller
{
    public function __construct(private TelegramService $telegramService)
    {
    }
    public function connect(string $shopId, TelegramRequest $request)
    {
        $data = $request->validated();
        $dto = TelegramConnectData::from($data);
        return  $this->telegramService->connect($shopId, $dto);
    }

    public function status(int $shopId): JsonResponse
    {
        try {
            $status = $this->telegramService->getStatus($shopId);

            return response()->json([
                'data'   => new TelegramStatusResource($status),
                'result' => 'SUCCESS',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'data'   => null,
                'result' => 'ERROR',
            ], 500);
        }
    }
}
