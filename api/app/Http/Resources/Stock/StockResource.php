<?php

namespace App\Http\Resources\Stock;

use App\Models\Stock;
use App\Http\Resources\BaseResource;


class StockResource extends BaseResource
{
    public function process($item): array
    {
        /**
         * @var Stock $item
         */

        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'symbol' => $item->getSymbol(),
            'price' => $item->getPrice(),
            'open' => $item->getOpen(),
            'high' => $item->getHigh(),
            'low' => $item->getLow(),
            'close' => $item->getClose(),
            'date' => $item->getDate()?->format('Y-m-d'),
            'userId' => $item->getUserId(),
            'createdAt' => $item->getCreatedAt(),
            'updatedAt' => $item->getUpdatedAt(),
        ];
    }
}
