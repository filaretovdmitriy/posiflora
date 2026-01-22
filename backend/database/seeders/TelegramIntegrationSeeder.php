<?php

namespace Database\Seeders;

use App\Models\TelegramIntegration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    }
}