<?php

namespace App\Http\Requests\Cart;

use App\Models\Cart;
use Illuminate\Foundation\Http\FormRequest;

class CartUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'integer', 'in:' . Cart::ADDED . ',' . Cart::REMOVED . ',' . Cart::CHECKED_OUT],
            'count' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if ((int)$value === 0 && (int)request('status') !== Cart::REMOVED) {
                        $fail(trans('general.count_zero'));
                    }
                },
            ]
        ];
    }
}
