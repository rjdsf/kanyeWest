<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\ValueObjects\QuotesValueObject;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property QuotesValueObject $resource
 */
class Quotes extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'author' => $this->resource->getAuthor(),
            'quotes' => $this->resource->getQuotes(),
        ];
    }
}
