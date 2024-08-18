<?php

declare(strict_types=1);

namespace Tests\Unit\Services\KanyeWestQuoteProvider\Core\Request;

use App\Services\KanyeWestQuoteProvider\Core\Request\KanyeWestQuoteRequest;
use App\ValueObjects\QuotesValueObject;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Mockery;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class KanyeWestQuoteRequestTest extends TestCase
{

    private Client & MockObject $client;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
    }


    /**
     * @throws Exception
     * @throws GuzzleException
     */
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

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->exactly(5))
            ->method('getStatusCode')
            ->willReturn(200);

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects($this->exactly(5))
            ->method('getContents')
            ->willReturn('{"quote":"I am the greatest"}');

        $response->expects($this->exactly(5))
            ->method('getBody')
            ->willReturn($stream);

        $this->client->expects($this->exactly(5))
            ->method('request')
            ->with('GET', 'https://api.kanye.rest')
            ->willReturn($response);


        $kaneWestQuoteProvider = new KanyeWestQuoteRequest($this->client);
        $result = $kaneWestQuoteProvider->getQuotes(5, true);

        $this->assertInstanceOf(QuotesValueObject::class, $result);
    }


    /**
     * @throws Exception
     */
    public function testFailGetCollectionCall(): void
    {
        Cache::shouldReceive('has')
            ->once()
            ->with('kanye-west-quotes')
            ->andReturn(false);


        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error while fetching Kanye West quote');

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(400);


        $this->client->expects($this->exactly(1))
            ->method('request')
            ->with('GET', 'https://api.kanye.rest')
            ->willReturn($response);


        $kaneWestQuoteProvider = new KanyeWestQuoteRequest($this->client);
        $result = $kaneWestQuoteProvider->getQuotes(5);

        $this->assertInstanceOf(QuotesValueObject::class, $result);
    }

    /**
     * @throws \Exception
     */
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

        $kaneWestQuoteProvider = new KanyeWestQuoteRequest($this->client);
        $result = $kaneWestQuoteProvider->getQuotes(5);

        $this->assertInstanceOf(QuotesValueObject::class, $result);
    }

}
