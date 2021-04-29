<?php

declare(strict_types=1);

namespace App\HPT;

use Symfony\Component\DomCrawler\Crawler;

interface Grabber
{
    public function getSearchCrawler(string $productId): Crawler;
    public function getName(Crawler $crawler): ?string;
    public function getPrice(Crawler $crawler): ?float;
    public function getRating(Crawler $crawler): ?int;
}
