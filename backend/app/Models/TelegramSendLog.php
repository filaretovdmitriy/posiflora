<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramSendLog extends Model
{
    use HasFactory;
    protected $table = 'telegram_send_log';

    protected $fillable = [
        'shop_id',
        'order_id',
        'message',
        'status',
        'error',
        'sent_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}