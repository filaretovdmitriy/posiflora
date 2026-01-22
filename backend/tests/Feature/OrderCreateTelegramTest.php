<?php

namespace Tests\Feature;

use App\Clients\TelegramClient;
use App\Models\Shop;
use App\Models\TelegramIntegration;
use App\Models\TelegramSendLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCreateTelegramTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_telegram_and_logs_sent_when_integration_enabled(): void
    {
        // given
        $shop = Shop::factory()->create();

        TelegramIntegration::factory()->create([
            'shop_id'   => $shop->id,
            'bot_token' => 'test-token',
            'chat_id'   => '123456',
            'enabled'   => true,
        ]);

        // мок TelegramClient
        $clientMock = $this->mock(TelegramClient::class, function ($mock) {
            $mock->shouldReceive('sendMessage')
                ->once()
                ->withArgs(function (string $token, string $chatId, string $text) {
                    // можно добавить простые проверки аргументов
                    return $token === 'test-token'
                        && $chatId === '123456'
                        && str_contains($text, 'Новый заказ');
                });
        });

        // when
        $response = $this->postJson("/api/shops/{$shop->id}/orders", [
            'number'       => 'A-1005',
            'total'        => 2490,
            'customerName' => 'Анна',
        ]);

        $response->dump();  
        //$response->assertStatus(200); // или 201, если выставишь код

        $this->assertDatabaseHas('orders', [
            'shop_id'       => $shop->id,
            'number'        => 'A-1005',
            'total'         => 2490,
            'customer_name' => 'Анна',
        ]);

        $orderId = $response->json('order.id');

        $this->assertDatabaseHas('telegram_send_log', [
            'shop_id' => $shop->id,
            'order_id'=> $orderId,
            'status'  => 'SENT',
        ]);

        $this->assertNotNull(
            TelegramSendLog::where('shop_id', $shop->id)->where('order_id', $orderId)->first()->sent_at
        );
    }

    public function it_is_idempotent_and_does_not_duplicate_logs_or_send_twice(): void
{
    $shop = Shop::factory()->create();

    TelegramIntegration::factory()->create([
        'shop_id'   => $shop->id,
        'bot_token' => 'test-token',
        'chat_id'   => '123456',
        'enabled'   => true,
    ]);

    // TelegramClient ожидаем только ОДИН вызов
    $this->mock(TelegramClient::class, function ($mock) {
        $mock->shouldReceive('sendMessage')
            ->once();
    });

    // создаём заказ напрямую
    $order = $shop->orders()->create([
        'number'        => 'A-1005',
        'total'         => 2490,
        'customer_name' => 'Анна',
    ]);

    // первый вызов use‑case
    $this->app->make(\App\Repositories\TelegramNotificationRepositoryInterface::class)
        ->notifyOrderCreated($order);

    // второй вызов use‑case для того же order
    $this->app->make(\App\Repositories\TelegramNotificationRepositoryInterface::class)
        ->notifyOrderCreated($order);

    // в БД только одна запись
    $this->assertEquals(1, TelegramSendLog::where('shop_id', $shop->id)
        ->where('order_id', $order->id)
        ->count());
}

public function it_logs_failed_when_telegram_client_throws_but_order_is_created(): void
{
    $shop = Shop::factory()->create();

    TelegramIntegration::factory()->create([
        'shop_id'   => $shop->id,
        'bot_token' => 'test-token',
        'chat_id'   => '123456',
        'enabled'   => true,
    ]);

    // мок: клиент бросает исключение
    $this->mock(TelegramClient::class, function ($mock) {
        $mock->shouldReceive('sendMessage')
            ->once()
            ->andThrow(new \RuntimeException('Telegram error'));
    });

    $response = $this->postJson("/shops/{$shop->id}/orders", [
        'number'       => 'A-1006',
        'total'        => 1490,
        'customerName' => 'Иван',
    ]);

    $response->assertStatus(200); // заказ создаётся

    $this->assertDatabaseHas('orders', [
        'shop_id'       => $shop->id,
        'number'        => 'A-1006',
        'total'         => 1490,
        'customer_name' => 'Иван',
    ]);

    $order = \App\Models\Order::where('shop_id', $shop->id)
        ->where('number', 'A-1006')
        ->first();

    $this->assertDatabaseHas('telegram_send_log', [
        'shop_id' => $shop->id,
        'order_id'=> $order->id,
        'status'  => 'FAILED',
    ]);

    $log = TelegramSendLog::where('shop_id', $shop->id)
        ->where('order_id', $order->id)
        ->first();

    $this->assertNotNull($log->error);
}

}