<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoucherResource;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\Voucher;
use Exception;
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
        $validatedData = $request->validate([
            'email' => 'required|email:filter|exists:App\Models\Customer,email'
        ]);

        $customerId = Customer::where('email', $validatedData['email'])->first()->id;

        $vouchers = Voucher::unused()->notExpired()->where('customer_id', $customerId)->with('offer')->get();

        return VoucherResource::collection($vouchers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email:filter|exists:App\Models\Customer,email',
            'offer_name' => 'required|exists:App\Models\Offer,name'
        ]);

        try {
            $customerId = Customer::where('email', $validatedData['email'])->first()->id;
            $offer = Offer::where('name', $validatedData['offer_name'])->first();

            return Voucher::create([
                'customer_id' => $customerId,
                'offer_id' => $offer->id,
                'expired_at' => $offer->expired_at
            ])->refresh();

        } catch (Exception $e) {
            if (config('app.debug')) {
                return ['message' => $e->getMessage()];
            }

            return ['message' => 'Erro ao criar Voucher individual'];
        }
    }
}
