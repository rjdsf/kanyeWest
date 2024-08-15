<?php
declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Support\Collection;

interface QuotesProviderInterface
{
    public function getQuotes(int $limit, bool $invalidateCache ): Collection;
    public function refreshQuotes(int $limit): Collection;
}
