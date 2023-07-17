<?php

namespace App\Http\Requests;

use App\Models\AmountLimit;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAmountLimitRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('amount_limit_create');
    }

    public function rules()
    {
        return [
            'royalties' => [
                'numeric',
                'required',
                'min:0',
            ],
            'advance_limit' => [
                'numeric',
                'required',
                'min:0',
            ],
            'artist_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
