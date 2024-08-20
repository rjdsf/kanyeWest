<?php
declare(strict_types=1);

namespace App\Services\KanyeWestQuoteProvider\Core\Exceptions;

class FailToRetrieveQuote extends \Exception
{
    private const string MESSAGE = 'Unable to retrieve Kanye West quote';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }

}
