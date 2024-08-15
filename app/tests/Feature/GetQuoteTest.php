<?php

namespace Tests\Feature;

use Tests\TestCase;

class GetQuoteTest extends TestCase
{

    public function testGetQuote()
    {
        $response =  $this->get('/kanye-west/quotes',
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. env('API_TOKEN'),
            ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRefreshQuote ()
    {
        $response =  $this->get('/kanye-west/quotes/refresh',
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. env('API_TOKEN'),
            ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

}
