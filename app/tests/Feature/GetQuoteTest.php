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
    private MockInterface & Response $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->response = Mockery::mock(Response::class);

    }

    public function testGetQuote(): void
    {

        $this->response->shouldReceive('status')
            ->times(5)
            ->andReturn(200);
        $this->response->shouldReceive('json')
            ->times(5)
            ->andReturn(['quote' => 'I am the greatest']);

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
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . config('api.token'),
            ])->assertOk()->assertJson([

            'data' => [
                'author' => 'Kanye West',
                'quotes' => [
                    'I am the greatest',
                    'I am the greatest',
                    'I am the greatest',
                    'I am the greatest',
                    'I am the greatest'
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
            ->andReturn(['quote' => 'Some quote from Kanye West']);

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
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . config('api.token'),
            ])->assertOk()->assertJson([
            'data' => [
                'author' => 'Kanye West',
                'quotes' => [
                    'Some quote from Kanye West',
                    'Some quote from Kanye West',
                    'Some quote from Kanye West',
                    'Some quote from Kanye West',
                    'Some quote from Kanye West'
                ]
            ]]);
    }

    public function testInvalidToken(): void
    {
        $this->post(uri: '/api/kanye-west/quotes/refresh',
            headers: [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . 'some_invalid_token',
            ])->assertUnauthorized();
    }

}
