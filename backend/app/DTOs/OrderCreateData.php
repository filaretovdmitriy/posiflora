<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class OrderCreateData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $number,
        public float $total,
        public string $customerName
    ) {
        //
    }
}
