<?php

namespace App\Http\Controllers;

use App\DTOs\TelegramConnectData;
use App\Http\Requests\TelegramRequest;
use App\Http\Resources\TelegramConnectResource;
use App\Http\Resources\TelegramStatusResource;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class TelegramController extends Controller
{

    public function __construct(private TelegramService $telegramService) {
        
    }
    public function connect(string $shopId, TelegramRequest $request)
    {
        $data = $request->validated();
        $dto = TelegramConnectData::from($data);
        return  $this->telegramService->connect($shopId, $dto);
    }

    public function status(int $shopId): TelegramStatusResource
    {
        $status = $this->telegramService->getStatus($shopId);

        return new TelegramStatusResource($status);
    }
}