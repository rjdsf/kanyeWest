<?php
declare(strict_types=1);

namespace  App\Services\KanyeWestQuoteProvider;

use App\Contracts\QuotesProviderInterface;
use App\Services\KanyeWestQuoteProvider\Core\Request\KanyeWestQuoteRequest;
use App\ValueObjects\QuotesValueObject;
use Exception;


readonly class KanyeWestQuoteProvider implements QuotesProviderInterface
{

    public function __construct(
        private KanyeWestQuoteRequest $kanyeWestQuoteRequest
    )
    {
    }

    /**
     * @throws Exception
     */
    public function getQuotes(int $limit = 5, bool $invalidateCache = false): QuotesValueObject
    {
       return $this->kanyeWestQuoteRequest->getQuotes($limit,$invalidateCache);
    }
}
