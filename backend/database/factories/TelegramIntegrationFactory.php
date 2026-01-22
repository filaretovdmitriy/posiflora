<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\TelegramIntegration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TelegramIntegration>
 */
class TelegramIntegrationFactory extends Factory
{
    protected $model = TelegramIntegration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shop_id'   => Shop::factory(),
            'bot_token' => $this->faker->sha1,
            'chat_id'   => (string) $this->faker->numberBetween(100000, 999999),
            'enabled'   => true,
        ];
    }
}
