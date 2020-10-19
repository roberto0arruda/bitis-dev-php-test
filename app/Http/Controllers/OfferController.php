<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequestValidation;
use App\Models\Offer;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Offer[]|Collection|Response
     */
    public function index()
    {
        return Offer::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OfferRequestValidation $request
     * @return array|Response
     */
    public function store(OfferRequestValidation $request)
    {
        try {
            return Offer::create($request->all())->refresh();
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
     * @param Offer $offer
     * @return Offer|Response
     */
    public function show(Offer $offer)
    {
        return $offer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OfferRequestValidation $request
     * @param Offer $offer
     * @return Offer|Response
     */
    public function update(OfferRequestValidation $request, Offer $offer)
    {
        $offer->update($request->all());

        return $offer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Offer $offer
     * @return Response
     * @throws Exception
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        return response()->noContent(); // 204 - No Content
    }
}
