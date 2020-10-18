<?php

namespace App\Http\Requests;

use App\Models\Voucher;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequestValidation extends FormRequest
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
        return [
            'code' => ['required', $this->voucherUsed()],
            'email' => 'required|email:filter'
        ];
    }

    private function voucherUsed()
    {
        return function ($attribute, $value, $fail) {
            $voucher = Voucher::where('used_at', NULL)->find($value);
            if ($voucher == NULL) {
                $fail('Voucher code invalido ou já utilizado!');
            }

            if ($voucher && $voucher->expired_at < now()->format('Y-m-d')) {
                $fail('Voucher code expirou!');
            }
        };
    }
}
