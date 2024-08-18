<?php
declare(strict_types=1);

namespace Tests\Unit\Services\KanyeWestQuoteProvider;

use App\Services\KanyeWestQuoteProvider\Core\Request\KanyeWestQuoteRequest;
use App\Services\KanyeWestQuoteProvider\KanyeWestQuoteProvider;
use App\ValueObjects\QuotesValueObject;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class KanyeWestQuoteProviderTest extends TestCase
{
    private KanyeWestQuoteRequest & MockObject $kaneWestQuoteProvider;
    protected function setUp():void
    {
        $this->kaneWestQuoteProvider = $this->createMock(KanyeWestQuoteRequest::class);
    }

    /**
     * @throws GuzzleException
     */
    public function testGetQuotes():void
    {
        $quote = new QuotesValueObject('Kanye West', new Collection());

        $this->kaneWestQuoteProvider->expects($this->once())
            ->method('getQuotes')
            ->with(5,false)
            ->willReturn($quote);

        $kaneWestQuoteProvider = new KanyeWestQuoteProvider($this->kaneWestQuoteProvider);
        $result = $kaneWestQuoteProvider->getQuotes();

        $this->assertInstanceOf(QuotesValueObject::class,$result);

    }

    public function testRefreshQuotes(): void
    {
        $quote = new QuotesValueObject('Kanye West', new Collection());

        $this->kaneWestQuoteProvider->expects($this->once())
            ->method('getQuotes')
            ->with(5,true)
            ->willReturn($quote);

        $kaneWestQuoteProvider = new KanyeWestQuoteProvider($this->kaneWestQuoteProvider);
        $result = $kaneWestQuoteProvider->getQuotes(5,true);

        $this->assertInstanceOf(QuotesValueObject::class,$result);
    }


}

