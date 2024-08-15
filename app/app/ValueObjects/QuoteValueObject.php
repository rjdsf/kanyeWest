<?php
declare(strict_types=1);

namespace App\ValueObjects;

readonly class QuoteValueObject
{

    public function __construct(
        private string $quote,
        private string $author
    ) {
    }

    public function getQuote(): string
    {
        return $this->quote;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }
}
