<?php

declare(strict_types=1);

namespace App\HPT;

interface Output
{
    public function getJson(): string;

    public function setOutputData(array $outputData): void;
}
