<?php

declare(strict_types=1);

namespace App\Item;

use App\HPT\Output;

class ItemOutput implements Output
{
    /** @var array<mixed> */
    private $outputData;

    public function getJson(): string
    {
        return json_encode($this->outputData);
    }

    public function setOutputData(array $outputData): void
    {
        $this->outputData = $outputData;
    }
}
