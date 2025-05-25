<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stock\GetStockPagedRequest;
use App\Http\Resources\Stock\StockResource;
use App\Mail\StockQuoteMail;
use App\Http\Requests\Stock\StockQuoteRequest;
use App\Models\User;
use App\Repositories\Stock\StockRepositoryInterface;
use App\Services\StockQuoteService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StockController extends Controller
{
    private StockRepositoryInterface $stockRepository;
    private StockQuoteService $stockQuoteService;

    public function __construct(
        StockRepositoryInterface $stockRepository,
        StockQuoteService $stockQuoteService
    )
    {
        $this->stockRepository = $stockRepository;
        $this->stockQuoteService = $stockQuoteService;
    }

    public function history(GetStockPagedRequest $request)
    {
        try {
            $values = $this->stockRepository->get($request);

            return $this->apiResponsePages(StockResource::collection($values['rows']),$values['count']);
        } catch (\Throwable $ex) {
            Log::error('Error while fetching data from stocks: '.$ex->getMessage());
            return $this->apiResponsePages(StockResource::collection([]), 0);
        }
    }

    public function quote(StockQuoteRequest $request) {
        try {
            /** @var User $user */
            $user = auth()->user();

            $quote = $this->stockQuoteService->fetchQuote($request->input('symbol'));

            if (!$quote) {
                return $this->apiError('Could not fetch stock data', 400);
            }

            $stock = $this->stockRepository->create(
                $user,
                $quote['name'],
                $quote['symbol'],
                $quote['price'],
                $quote['open'],
                $quote['high'],
                $quote['low'],
                $quote['close'],
                $quote['date']
            );

            Mail::to($user->getEmail())->send(new StockQuoteMail($stock));

            return $this->apiResponse(new StockResource($stock));
        } catch (\Throwable $th) {
            return $this->apiError($th->getMessage(), 400);
        }
    }
}
