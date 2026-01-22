<?php

namespace App\Http\Controllers;

use App\DTOs\OrderCreateData;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderCreateResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class OrdersController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
        
    }
    public function store(OrderRequest $request, int $shopId): JsonResponse
    {
        $data = $request->validated();

        $result = $this->orderService->orderCreate($shopId, OrderCreateData::from($data));
        return (new OrderCreateResource($result))
        ->response();
      
    }
}