<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequestValidation;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param CheckoutRequestValidation $request
     * @return array|JsonResponse|Response
     */
    public function __invoke(CheckoutRequestValidation $request)
    {
        $voucher = Voucher::find($request->input('code'));
        $customer = Customer::where('email', $request->input('email'))->first();

        // voucher é valido e pertence ao cliente
        if ($voucher->customer_id == $customer->id) {
            $voucher->used_at = now();
            $voucher->update();
            return ['discount_percentage' => Offer::find($voucher->offer_id)->discount_percentage];
        }

        return response()->json(['message' => 'Voucher code não pertence ao cliente!'], 422);
    }
}
