<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramIntegration extends Model
{
    use HasFactory;

    protected $table = 'telegram_integrations';

    protected $fillable = [
        'shop_id',
        'bot_token',
        'chat_id',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'bool',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
