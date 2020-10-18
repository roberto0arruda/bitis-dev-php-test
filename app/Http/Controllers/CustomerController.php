<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequestValidation;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return CustomerResource::collection(Customer::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequestValidation $request
     * @return array|Response
     */
    public function store(CustomerRequestValidation $request)
    {
        try {
            return Customer::create($request->all())->refresh();
        } catch (Exception $e) {
            if (config('app.debug')) {
                return ['message' => $e->getMessage()];
            }

            return ['message' => 'Erro ao criar Cliente'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return CustomerResource
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequestValidation $request
     * @param Customer $customer
     * @return Customer
     */
    public function update(CustomerRequestValidation $request, Customer $customer)
    {
        $customer->update($request->all());

        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return Response
     * @throws Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent(); // 204 - No Content
    }
}
