<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TelegramStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
      public function toArray($request): array
    {
        return [
            'enabled'     => $this['enabled'],
            'chatId'      => $this['chatId'],
            'lastSentAt'  => optional($this['lastSentAt'])->toISOString(),
            'sentCount'   => $this['sentCount'],
            'failedCount' => $this['failedCount'],
        ];
    }
}