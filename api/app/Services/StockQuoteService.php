<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StockQuoteService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.alphavantage.key');
        $this->baseUrl = config('services.alphavantage.url');
    }

    public function fetchQuote(string $symbol): ?array
    {
        $response = Http::get($this->baseUrl, [
            'function' => 'GLOBAL_QUOTE',
            'symbol' => $symbol,
            'apikey' => $this->apiKey,
        ]);

        if (!$response->ok()) {
            return null;
        }

        $data = $response->json();
        $quote = $data['Global Quote'] ?? null;

        if (!$quote) {
            Log::error("error while get data from external api: ", $data);
            return null;
        }

        return [
            'name' => $symbol,
            'symbol' => $quote['01. symbol'] ?? $symbol,
            'open' => isset($quote['02. open']) ? (float)$quote['02. open'] : null,
            'high' => isset($quote['03. high']) ? (float)$quote['03. high'] : null,
            'low' => isset($quote['04. low']) ? (float)$quote['04. low'] : null,
            'price' => isset($quote['05. price']) ? (float)$quote['05. price'] : null,
            'date' => isset($quote['07. latest trading day']) ? Carbon::parse($quote['07. latest trading day'])->format('Y-m-d') : null,
            'close' => isset($quote['08. previous close']) ? (float)$quote['08. previous close'] : null,
        ];
    }
}
