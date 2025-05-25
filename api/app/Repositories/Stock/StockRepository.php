<?php

namespace App\Repositories\Stock;

use App\Http\Requests\Stock\GetStockPagedRequest;
use App\Models\Factories\Stock\StockFactory;
use App\Models\Stock;
use App\Models\User;
use App\Modules\Exceptions\FatalRepositoryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StockRepository implements StockRepositoryInterface
{
    private StockFactory $stockFactory;

    /**
     * @param StockFactory $stockFactory
     */
    public function __construct(
        StockFactory $stockFactory
    ) {
        $this->stockFactory = $stockFactory;
    }

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
     * @throws FatalRepositoryException
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
    ): Stock
    {
        return $this->stockFactory->create(
            $user,
            $name,
            $symbol,
            $price,
            $open,
            $high,
            $low,
            $close,
            $date
        );
    }

    /**
     * @param ?GetStockPagedRequest $request
     * @return mixed
     */
    public function get(GetStockPagedRequest $request = null): mixed
    {
        if (!$request) {
            $request = new GetStockPagedRequest();
        }

        $searchKeyword = $request->input('search');
        $index = intval($request->input('pageIndex', 1));
        $size = intval($request->input('pageSize', 2));
        $sortBy = $request->input('sortBy', 'name');
        $sortDesc = $request->boolean('sortDesc', true);

        $columnsToSearch = [
            'name',
            'symbol',
        ];

        return $this->stockFactory->get(
            $searchKeyword,
            $columnsToSearch,
            $index - 1,
            $size,
            $sortBy,
            $sortDesc
        );
    }

}
