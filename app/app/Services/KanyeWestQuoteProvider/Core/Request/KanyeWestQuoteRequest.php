<?php

declare(strict_types=1);

namespace App\Services\KanyeWestQuoteProvider\Core\Request;

use App\Services\KanyeWestQuoteProvider\Core\Exceptions\FailToRetrieveQuote;
use App\ValueObjects\QuotesValueObject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class KanyeWestQuoteRequest
{

    private const string CACHE_KEY = 'kanye-west-quotes';

    public function getQuotes(int $limit, bool $invalidateCache = false): QuotesValueObject
    {
        if ($invalidateCache) {
            Cache::forget(self::CACHE_KEY);
        }
        if (Cache::has(self::CACHE_KEY)) {
            return Cache::get(self::CACHE_KEY);
        }

        $quotes = new QuotesValueObject('Kanye West',$this->getQuoteCollection($limit));

        Cache::put(self::CACHE_KEY, $quotes, now()->addMinutes(5));

        return $quotes;
    }

    private function getQuoteCollection(int $limit, ?Collection $collection = null): collection
    {
        if (is_null($collection)) {
            $collection = new Collection();
        }
        $response = Http::get( 'https://api.kanye.rest');
        if ($response->status() !== 200) {
            throw new FailToRetrieveQuote();
        }
        $content = $response->json();

        $collection->add($content['quote']);

        if ($collection->count() === $limit) {
            return $collection;
        }

        return $this->getQuoteCollection($limit, $collection);
    }

}
