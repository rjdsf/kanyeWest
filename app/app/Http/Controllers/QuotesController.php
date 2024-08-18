<?php

namespace App\Http\Controllers;

use App\Http\Resources\Quotes;
use App\Managers\QuoteManager;

class QuotesController extends Controller
{
    public function list(QuoteManager $quoteManager): Quotes
    {
        $quotes = $quoteManager->driver('kanyeWest')->getQuotes(5);
        return new Quotes($quotes);
    }

    public function refreshList(QuoteManager $quoteManager): Quotes
    {
        $quotes = $quoteManager->driver('kanyeWest')->getQuotes(5, true);
        return new Quotes($quotes);
    }
}
