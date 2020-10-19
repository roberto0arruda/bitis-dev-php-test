<?php

namespace Tests\Feature\Http\Requests;

use App\Models\Offer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OfferRequestValidationTest extends TestCase
{
    use DatabaseMigrations;

    public function testCheckIfFieldsIsRequiredOnCreate()
    {
        $response = $this->postJson(route('offers.store'));

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'discount_percentage', 'expired_at'
            ])
            ->assertExactJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'discount_percentage' => ['The discount percentage field is required.'],
                    'expired_at' => ['The expired at field is required.']
                ]
            ])
            ->assertJsonCount(3, 'errors');
    }

    public function testCheckIfOfferNameShouldBeUniqueForEachDateOnCreate()
    {
        $startDate = time();
        $dt = date('Y-m-d', strtotime('+1 day', $startDate));
        $dt2 = date('Y-m-d', strtotime('+2 day', $startDate));

        factory(Offer::class)->create([
            'name' => 'dia das crianças',
            'discount_percentage' => 10,
            'expired_at' => $dt
        ]);
        $response = $this->postJson(route('offers.store'), [
            'name' => 'dia das crianças',
            'discount_percentage' => 10,
            'expired_at' => $dt
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name'
            ])
            ->assertExactJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name has already been taken.']
                ]
            ])
            ->assertJsonCount(1, 'errors');

        $response = $this->postJson(route('offers.store'), [
            'name' => 'dia das crianças',
            'discount_percentage' => 10,
            'expired_at' => $dt2
        ]);
        $response->assertStatus(201)->assertCreated();
    }
}
