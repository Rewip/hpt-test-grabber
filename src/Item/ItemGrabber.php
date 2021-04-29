<?php

declare(strict_types=1);

namespace App\Item;

use App\HPT\Grabber;
use Symfony\Component\DomCrawler\Crawler;

class ItemGrabber implements Grabber
{
    private const SEARCH_URI = 'https://www.czc.cz/%s/hledat';

    public function getSearchCrawler(string $productId): Crawler
    {
        try {
            $html = file_get_contents(sprintf(self::SEARCH_URI, $productId));
            $crawler = (new Crawler($html))->filter('#tiles')->filter('.new-tile')->first();

            if($crawler->count() === 0) {
                throw new \Exception('This product doesn\'t exist or isn\'t searchable');
            }

            return $crawler;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getName(Crawler $crawler): ?string
    {
        try {
            $name = $crawler->filter('.tile-title')->filter('h5')->filter('a')->text();
        } catch (\Exception $exception) {
            return null;
        }

        return $name;
    }

    public function getPrice(Crawler $crawler): ?float
    {
        try {
            $priceText = $crawler->filter('.price')->filter('.price-vatin')->text();
        } catch (\Exception $exception) {
            return null;
        }

        return floatval(preg_replace('/\D/', '', $priceText));
    }

    public function getRating(Crawler $crawler): ?int
    {
        try {
            $rating = $crawler->filter('.overflow')->filter('.rating')->attr('title');
        } catch (\Exception $exception) {
            return null;
        }

        return intval(preg_replace('/\D/', '', explode('%', $rating)[0]));
    }
}
