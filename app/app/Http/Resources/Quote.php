<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\ValueObjects\QuoteValueObject;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property QuoteValueObject $resource
 */
class Quote extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'author' => $this->resource->getAuthor(),
            'quote' => $this->resource->getQuote(),
        ];
    }
}
