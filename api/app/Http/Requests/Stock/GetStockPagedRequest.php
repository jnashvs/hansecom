<?php

namespace App\Http\Requests\Stock;

use App\Http\Requests\BaseRequest;

class GetStockPagedRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search' => 'nullable|string',
            'pageIndex' => 'nullable|integer|min:1',
            'pageSize' => 'nullable|integer|min:2',
            'sortBy' => 'nullable|string',
            'sortDesc' => 'nullable|boolean',
        ];
    }
}
