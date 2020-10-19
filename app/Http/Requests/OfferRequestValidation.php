<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfferRequestValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(3);

        if ($id == null) {
            return [
                'discount_percentage' => 'required|numeric|min:1|max:100',
                'name' => [
                    'required',
                    Rule::unique('offers')->where('expired_at', $this->expired_at)
                ],
                'expired_at' => 'required|date|date_format:Y-m-d|after_or_equal:today'
            ];
        }

        return [
            'discount_percentage' => 'numeric|min:5|max:75',
            'expired_at' => 'required|date|date_format:Y-m-d|after_or_equal:today'
        ];
    }
}
