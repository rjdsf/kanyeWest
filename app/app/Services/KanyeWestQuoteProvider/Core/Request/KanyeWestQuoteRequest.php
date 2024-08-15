<?php

declare(strict_types=1);

namespace App\Services\KanyeWestQuoteProvider\Core\Request;

use App\ValueObjects\QuoteValueObject;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class KanyeWestQuoteRequest
{

    private const string CACHE_KEY = 'kanye-west-quotes';

    public function __construct(
        private readonly Client $client
    ) {
    }

    /**
     * @return Collection<QuoteValueObject>
     * @throws Exception|GuzzleException
     */
    public function getQuotes(int $limit, bool $invalidateCache = false): Collection
    {
        if ($invalidateCache) {
            Cache::forget(self::CACHE_KEY);
        }
        if (Cache::has(self::CACHE_KEY)) {
            return Cache::get(self::CACHE_KEY);
        }

        $quotes = $this->getQuoteCollection($limit);
        Cache::put(self::CACHE_KEY, $quotes, now()->addMinutes(5));

        return $quotes;
    }


    /**
     * @throws GuzzleException
     * @throws Exception
     */
    private function getQuoteCollection(int $limit, ?Collection $collection = null): collection
    {
        if (is_null($collection)) {
            $collection = new Collection();
        }
        $response = $this->client->request('GET', 'https://api.kanye.rest');
        if ($response->getStatusCode() !== 200) {
            throw new Exception('Error while fetching Kanye West quote');
        }
        $content = json_decode($response->getBody()->getContents(), true);

        $collection->add(new QuoteValueObject($content['quote'], 'Kanye West'));

        if ($collection->count() === $limit) {
            return $collection;
        }

        return $this->getQuoteCollection($limit, $collection);
    }

}
