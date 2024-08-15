<?php
declare(strict_types=1);

namespace App\Managers;
use App\Contracts\QuotesProviderInterface;
use App\Services\KanyeWestQuoteProvider\KanyeWestQuoteProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Manager;

class QuoteManager extends Manager
{

    public function getDefaultDriver(): string
    {
        return 'kanyeWest';
    }


    /**
     * @throws BindingResolutionException
     */
    public function createKanyeWestDriver(): QuotesProviderInterface
    {
        return   $this->container->make(KanyeWestQuoteProvider::class);

    }
}
