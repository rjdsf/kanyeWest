<?php
declare(strict_types=1);

namespace App\Contracts;

use App\ValueObjects\QuotesValueObject;

interface QuotesProviderInterface
{
    public function getQuotes(int $limit, bool $invalidateCache ): QuotesValueObject;
}
