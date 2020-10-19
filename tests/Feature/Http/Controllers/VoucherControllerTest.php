<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class VoucherControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testForEmailShouldBeReturnedTheVouchersValidWithOfferName()
    {
        $startDate = time();
        $dt = date('Y-m-d', strtotime('+1 day', $startDate));
        $customers = factory(Customer::class, 5)->create();
        $this->postJson(route('offers.store'), [
            'name' => 'test',
            'discount_percentage' => 25,
            'expired_at' => $dt
        ]);
        $this->postJson(route('offers.store'), [
            'name' => 'test2',
            'discount_percentage' => 30,
            'expired_at' => $dt
        ]);

        $response = $this->getJson('api/vouchers?email=' . $customers[0]->email);

        $response
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function testCheckIfVoucherIsCreated()
    {
        $startDate = time();
        $dt = date('Y-m-d', strtotime('+1 day', $startDate));
        $customers = factory(Customer::class, 5)->create();
        $this->postJson(route('offers.store'), [
            'name' => 'test',
            'discount_percentage' => 25,
            'expired_at' => $dt
        ]);
        $this->postJson(route('offers.store'), [
            'name' => 'test2',
            'discount_percentage' => 30,
            'expired_at' => $dt
        ]);

        $response = $this->getJson('api/vouchers?email=' . $customers[0]->email);

        $response
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');


        $response = $this->postJson('api/vouchers', [
            'email' => $customers[0]->email,
            'offer_name' => 'test2'
        ]);

        $response->assertStatus(201);

        $response = $this->getJson('api/vouchers?email=' . $customers[0]->email);
        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }
}
