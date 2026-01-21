<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class OrdersController extends Controller
{
    public function store(OrderRequest $request): Response
    {
        // логика создания заказа
        $data = $request->validate();
        return response()->noContent(); 
    }
}