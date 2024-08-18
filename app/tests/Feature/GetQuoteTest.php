<?php

namespace Tests\Feature;

use Tests\TestCase;

class GetQuoteTest extends TestCase
{

    public function testGetQuote()
    {
        $response = $this->get(uri: '/api/kanye-west/quotes',
            headers: [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . env('API_TOKEN'),
            ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRefreshQuote()
    {
        $response = $this->post(uri: '/api/kanye-west/quotes/refresh',
            headers: [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . env('API_TOKEN'),
            ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

}
