<?php
declare(strict_types=1);

namespace  App\Services\KanyeWestQuoteProvider;

use App\Contracts\QuotesProviderInterface;
use App\Services\KanyeWestQuoteProvider\Core\Request\KanyeWestQuoteRequest;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;


readonly class KanyeWestQuoteProvider implements QuotesProviderInterface
{

    public function __construct(
        private KanyeWestQuoteRequest $kanyeWestQuoteRequest
    )
    {
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function getQuotes(int $limit = 5, bool $invalidateCache = false): Collection
    {
       return $this->kanyeWestQuoteRequest->getQuotes($limit,$invalidateCache);
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function refreshQuotes(int $limit = 5): Collection
    {
        return $this->kanyeWestQuoteRequest->getQuotes($limit,true);
    }
}
