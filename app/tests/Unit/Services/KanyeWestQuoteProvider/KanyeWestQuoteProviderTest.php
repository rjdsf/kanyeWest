<?php
declare(strict_types=1);

namespace Tests\Unit\Services\KanyeWestQuoteProvider;

use App\Services\KanyeWestQuoteProvider\Core\Request\KanyeWestQuoteRequest;
use App\Services\KanyeWestQuoteProvider\KanyeWestQuoteProvider;
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

    public function testGetQuotes():void
    {
        $this->kaneWestQuoteProvider->expects($this->once())
            ->method('getQuotes')
            ->with(5,false)
            ->willReturn(new Collection());

        $kaneWestQuoteProvider = new KanyeWestQuoteProvider($this->kaneWestQuoteProvider);
        $result = $kaneWestQuoteProvider->getQuotes();

        $this->assertInstanceOf(Collection::class,$result);

    }

    public function testRefreshQuotes(): void
    {
        $this->kaneWestQuoteProvider->expects($this->once())
            ->method('getQuotes')
            ->with(5,true)
            ->willReturn(new Collection());

        $kaneWestQuoteProvider = new KanyeWestQuoteProvider($this->kaneWestQuoteProvider);
        $result = $kaneWestQuoteProvider->refreshQuotes();

        $this->assertInstanceOf(Collection::class,$result);
    }


}

