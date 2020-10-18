<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoucherResource;
use App\Models\Customer;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $request->validate([
            'email' => 'required|email:filter|exists:App\Models\Customer,email'
        ]);

        $customerId = Customer::where('email', $request->input('email'))->first()->id;

        $vouchers = Voucher::unused()->notExpired()->where('customer_id', $customerId)->with('offer')->get();

        return VoucherResource::collection($vouchers);
    }
}
