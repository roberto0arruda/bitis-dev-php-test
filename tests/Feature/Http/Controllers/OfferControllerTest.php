<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Offer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OfferControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCheckIfIndexFunctionIsWorking()
    {
        factory(Offer::class, 10)->create();

        $response = $this->get(route('offers.index'));

        $response
            ->assertStatus(200)
            ->assertJsonCount(10);
    }

    public function testCheckIfShowFunctionIsWorking()
    {
        $offer = factory(Offer::class)->create();

        $response = $this->getJson(route('offers.show', ['offer' => $offer->id]));
        $response
            ->assertStatus(200)
            ->assertJson($offer->toArray());

        $response = $this->getJson(route('offers.show', ['offer' => 2]));

        $response
            ->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'No query results for model [App\Models\Offer] 2'
            ]);
    }

    public function testCheckIfStoreFunctionIsWorking()
    {
        $startDate = time();
        $dt = date('Y-m-d', strtotime('+1 day', $startDate));

        $response = $this->postJson(route('offers.store'), [
            'name' => 'test',
            'discount_percentage' => 25,
            'expired_at' => $dt
        ]);

        $id = $response->json('id');
        $offer = Offer::find($id);
        $response
            ->assertStatus(201)
            ->assertJson($offer->toArray());
    }

    public function testCheckIfUpdateFunctionIsWorking()
    {
        $startDate = time();
        $dt = date('Y-m-d', strtotime('+1 day', $startDate));

        $offer = factory(Offer::class)->create([
            'name' => 'test',
            'discount_percentage' => 25,
            'expired_at' => $dt
        ]);

        $response = $this->putJson(
            route('offers.update', ['offer' => $offer->id]),
            [
                'name' => 'test_update'
            ]
        );

        $id = $response->json('id');
        $offer = Offer::find($id);
        $response
            ->assertStatus(200)
            ->assertJson($offer->toArray())
            ->assertJsonFragment([
                'name' => 'test_update'
            ]);
    }

    public function testCheckIfDestroyFunctionIsWorking()
    {
        $offer = factory(Offer::class)->create();

        $response = $this->deleteJson(route('offers.destroy', ['offer' => $offer->id]));
        $response->assertStatus(204);

        $response = $this->deleteJson(route('offers.destroy', ['offer' => $offer->id]));
        $response
            ->assertStatus(404)
            ->assertJsonFragment([
                'message' => "No query results for model [App\Models\Offer] {$offer->id}"
            ]);
    }
}
