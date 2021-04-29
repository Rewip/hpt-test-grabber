<?php

declare(strict_types=1);

namespace App\Application;

use App\HPT\Dispatcher;
use App\Item\ItemGrabber;
use App\Item\ItemOutput;

class ApplicationDispatcher extends Dispatcher
{
    /** @var array<string> */
    private $codes;

    /** @var array<mixed> */
    private $data;

    public function __construct(ItemGrabber $grabber, ItemOutput $output)
    {
        parent::__construct($grabber, $output);
    }

    public function run(): string
    {
        try {
            // First load input file and check it ( blank new lines, file exists, etc )
            $this->codes = $this->readInputFile();

            // Run grabber and get wanted data
            foreach ($this->codes as $code) {
                try {
                    $this->data[$code] = [
                        'price' => $this->getGrabber()->getPrice($code)
                    ];
                } catch (\Exception $exception) {
                    $this->data[$code] = null;
                }
            }

            // Insert data into out Output thingy
            $this->getOutput()->setOutputData($this->data);

        } catch (\Exception $exception) {
            $this->getOutput()->setOutputData(['error' => $exception->getMessage(), 'stacktrace' => $exception->getTraceAsString()]);
        }

        // Finally return our JSON
        return $this->getOutput()->getJson();
    }

    /**
     * @return array<string>
     * @throws \Exception
     */
    private function readInputFile(): array
    {
        try {
            return $array = array_filter(explode("\r\n", file_get_contents(__DIR__ . '/../../vstup.txt')));
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
