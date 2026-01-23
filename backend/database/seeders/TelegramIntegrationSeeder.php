<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\TelegramIntegration;
use Illuminate\Database\Seeder;

class TelegramIntegrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TelegramIntegration::factory()
            ->count(20)
            ->create();

        $shop = Shop::factory()->create([
            'name' => 'Shop 123',
        ]);

        TelegramIntegration::factory()->create([
            'shop_id' => $shop->id,
        ]);
    }
}
