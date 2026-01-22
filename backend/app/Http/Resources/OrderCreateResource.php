<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCreateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $order = $this['order'];

        return [
            'order' => [
                'id'           => $order->id,
                'number'       => $order->number,
                'total'        => $order->total,
                'customerName' => $order->customer_name,
                'createdAt'    => $order->created_at?->toISOString(),
            ],
            'telegram' => [
                'status' => $this['status'],
            ],
        ];
    }
}
