<?php

declare(strict_types=1);

namespace App\HPT;

interface Grabber
{
    public function getPrice(string $productId): float;
}
