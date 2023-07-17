<?php

namespace App\Http\Requests;

use App\Models\Artist;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateArtistRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('artist_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:5',
                'max:100',
                'required',
            ],
            'phone' => [
                'string',
                'min:10',
                'max:14',
                'required',
                'unique:artists,phone,' . request()->route('artist')->id,
            ],
        ];
    }
}
