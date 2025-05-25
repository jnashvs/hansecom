<?php

namespace App\Models\Factories\Stock;

use App\Models\Stock;
use App\Models\Factories\AbstractFactory;
use App\Models\User;
use App\Modules\Exceptions\FatalRepositoryException;
use Carbon\Carbon;

/**
 *
 */
class StockFactory extends AbstractFactory
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(Stock::class);
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
    ): Stock {
        $stock = new Stock();
        $stock->setName($name);
        $stock->setSymbol($symbol);
        $stock->setPrice($price);
        $stock->setOpen($open);
        $stock->setHigh($high);
        $stock->setLow($low);
        $stock->setClose($close);
        $stock->setDate($date);
        $stock->setUser($user);

        if (!$stock->save()) {
            throw new FatalRepositoryException('Failed to create a stock.');
        }

        return $stock;
    }

}
