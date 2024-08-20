<?php

declare(strict_types=1);

namespace Tests\Unit\Services\KanyeWestQuoteProvider\Core\Request;

use App\Services\KanyeWestQuoteProvider\Core\Exceptions\FailToRetrieveQuote;
use App\Services\KanyeWestQuoteProvider\Core\Request\KanyeWestQuoteRequest;
use App\ValueObjects\QuotesValueObject;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Mockery;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;


class KanyeWestQuoteRequestTest extends TestCase
{

    private Response & MockObject $response;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->response = $this->createMock(Response::class);
    }

    public function testGetQuotes(): void
    {
        Cache::shouldReceive('has')
            ->once()
            ->with('kanye-west-quotes')
            ->andReturn(false);

        Cache::shouldReceive('forget')
            ->once()
            ->with('kanye-west-quotes');

        Cache::shouldReceive('put')
            ->once()
            ->with(
                'kanye-west-quotes',
                Mockery::on(function ($quotes) {
                    return $quotes instanceof QuotesValueObject && $quotes->getQuotes()->count() === 5;
                }),
                Mockery::type('DateTime')
            );

        $this->response->expects($this->exactly(5))
            ->method('status')
            ->willReturn(200);

        $this->response->expects($this->exactly(5))
            ->method('json')
            ->willReturn(['quote' => 'I am the greatest']);

        Http::shouldReceive('get')
            ->times(5)
            ->with('https://api.kanye.rest')
            ->andReturn($this->response);


        $kaneWestQuoteProvider = new KanyeWestQuoteRequest();
        $result = $kaneWestQuoteProvider->getQuotes(5, true);

        $this->assertInstanceOf(QuotesValueObject::class, $result);
    }


    public function testFailGetCollectionCall(): void
    {
        Cache::shouldReceive('has')
            ->once()
            ->with('kanye-west-quotes')
            ->andReturn(false);


        $this->expectException(FailToRetrieveQuote::class);
        $this->expectExceptionMessage('Unable to retrieve Kanye West quote');


        $this->response->expects($this->once())
            ->method('status')
            ->willReturn(400);

        Http::shouldReceive('get')
            ->once()
            ->with('https://api.kanye.rest')
            ->andReturn($this->response);



        $kaneWestQuoteProvider = new KanyeWestQuoteRequest();
        $result = $kaneWestQuoteProvider->getQuotes(5);

        $this->assertInstanceOf(QuotesValueObject::class, $result);
    }

    public function testGetQuotesWithExistentCache(): void
    {
        Cache::shouldReceive('has')
            ->once()
            ->with('kanye-west-quotes')
            ->andReturn(true);

        Cache::shouldReceive('get')
            ->once()
            ->with('kanye-west-quotes')
            ->andReturn(new QuotesValueObject('Kanye West', new Collection()));

        $kaneWestQuoteProvider = new KanyeWestQuoteRequest();
        $result = $kaneWestQuoteProvider->getQuotes(5);

        $this->assertInstanceOf(QuotesValueObject::class, $result);
    }

}
