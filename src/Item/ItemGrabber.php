<?php

declare(strict_types=1);

namespace App\Item;

use App\HPT\Grabber;
use Nette\Neon\Exception;
use Symfony\Component\DomCrawler\Crawler;

class ItemGrabber implements Grabber
{
    private const SEARCH_URI = 'https://www.czc.cz/%s/hledat';

    public function getPrice(string $productId): float
    {
        $html = file_get_contents(sprintf(self::SEARCH_URI, $productId));
        $crawler = new Crawler($html);

        try {
            $priceText = $crawler->filter('#tiles')->filter('.new-tile')->first()->filter('.price')->filter('.price-vatin')->text();
        } catch (Exception $exception) {
            throw $exception;
        }

        return floatval(preg_replace('/\D/', '', $priceText));
    }
}
