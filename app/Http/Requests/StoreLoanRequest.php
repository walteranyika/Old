<?php

namespace App\Http\Requests;

use App\Models\Loan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLoanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('loan_create');
    }

    public function rules()
    {
        return [
            'amount' => [
                'numeric',
                'required',
                'min:0',
            ],
            'code' => [
                'string',
                'nullable',
            ],
            'duration' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'repaid' => [
                'required',
            ],
            'artist_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
