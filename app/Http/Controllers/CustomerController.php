<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public function index()
    {
        return Customer::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array|Response
     */
    public function store(Request $request)
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
     * @return Customer
     */
    public function show(Customer $customer)
    {
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Customer $customer
     * @return Customer
     */
    public function update(Request $request, Customer $customer)
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
