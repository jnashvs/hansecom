<?php

namespace App\Repositories\Stock;

use App\Http\Requests\Stock\GetStockPagedRequest;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;

/**
 *
 */
interface StockRepositoryInterface
{
    /**
     * @param User $user
     * @param string $name
     * @param string $symbol
     * @param float $price
     * @param float $open
     * @param float $high
     * @param float $low
     * @param float $close
     * @param string $date
     * @return Stock
     */
    public function create(
        User $user,
        string $name,
        string $symbol,
        float $price,
        float $open,
        float $high,
        float $low,
        float $close,
        string $date
    ): Stock;

    /**
     * @param ?GetStockPagedRequest $request
     * @return mixed
     */
    public function get(GetStockPagedRequest $request = null): mixed;
}
