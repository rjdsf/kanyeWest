<?php
declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Support\Collection;

readonly class QuotesValueObject
{

    public function __construct(
        private string $author,
        private Collection $quotes,
    ) {
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getQuotes(): Collection
    {
        return $this->quotes;
    }
}
