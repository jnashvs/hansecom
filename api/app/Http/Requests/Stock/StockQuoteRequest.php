<?php

namespace App\Http\Requests\Stock;

use App\Http\Requests\BaseRequest;

class StockQuoteRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'symbol' => 'required|string|max:10',
        ];
    }
}