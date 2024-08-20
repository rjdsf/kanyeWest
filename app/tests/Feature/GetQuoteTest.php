<?php

namespace Tests\Feature;


use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;


class GetQuoteTest extends TestCase
{

    private const string QUOTE = 'Some quote from Kanye West';
    private const string ACCEPT = 'application/json';
    private string $authorization = '';

    private MockInterface & Response $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->response = Mockery::mock(Response::class);
        $this->authorization = 'Bearer ' . config('api.token');

    }

    public function testGetQuote(): void
    {

        $this->response->shouldReceive('status')
            ->times(5)
            ->andReturn(200);
        $this->response->shouldReceive('json')
            ->times(5)
            ->andReturn(['quote' => self::QUOTE]);

        Cache::shouldReceive('has')
            ->once()
            ->with('kanye-west-quotes')
            ->andReturn(false);

        Cache::shouldReceive('put')
            ->times(1);

        Http::shouldReceive('get')
            ->times(5)
            ->with('https://api.kanye.rest')
            ->andReturn($this->response);

        $this->app->instance(Response::class, $this->response);


        $this->get(uri: '/api/kanye-west/quotes',
            headers: [
                'Accept' => self::ACCEPT,
                'Authorization' => $this->authorization,
            ])->assertOk()->assertJson([

            'data' => [
                'author' => 'Kanye West',
                'quotes' => [
                    self::QUOTE,
                    self::QUOTE,
                    self::QUOTE,
                    self::QUOTE,
                    self::QUOTE,
                ]
            ]
        ]);

    }

    public function testRefreshQuote(): void
    {

        $this->response->shouldReceive('status')
            ->times(5)
            ->andReturn(200);

        $this->response->shouldReceive('json')
            ->times(5)
            ->andReturn(['quote' => self::QUOTE,]);

        Cache::shouldReceive('forget')
            ->once()
            ->with('kanye-west-quotes');

        Cache::shouldReceive('has')
            ->once()
            ->with('kanye-west-quotes')
            ->andReturn(false);

        Cache::shouldReceive('put')
            ->times(1);


        Http::shouldReceive('get')
            ->times(5)
            ->with('https://api.kanye.rest')
            ->andReturn($this->response);


        $this->post(uri: '/api/kanye-west/quotes/refresh',
            headers: [
                'Accept' => self::ACCEPT,
                'Authorization' => $this->authorization,
            ])->assertOk()->assertJson([
            'data' => [
                'author' => 'Kanye West',
                'quotes' => [
                    self::QUOTE,
                    self::QUOTE,
                    self::QUOTE,
                    self::QUOTE,
                    self::QUOTE,
                ]
            ]]);
    }

    public function testInvalidToken(): void
    {
        $this->post(uri: '/api/kanye-west/quotes/refresh',
            headers: [
                'Accept' => self::ACCEPT,
                'Authorization' => 'some_invalid_token',
            ])->assertUnauthorized();
    }

}
