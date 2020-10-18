<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testCheckIfIndexFunctionIsWorking()
    {
        factory(Customer::class, 10)->create();

        $response = $this->get(route('customers.index'));

        $response
            ->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }

    public function testCheckIfShowFunctionIsWorking()
    {
        $customer = factory(Customer::class)->create();

        $response = $this->getJson(route('customers.show', ['customer' => $customer->id]));
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'vouchers' => []
                ]
            ]);

        $response = $this->getJson(route('customers.show', ['customer' => 2]));

        $response
            ->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'No query results for model [App\Models\Customer] 2'
            ]);
    }

    public function testCheckIfStoreFunctionIsWorking()
    {
        $response = $this->postJson(route('customers.store'), [
            'name' => 'test',
            'email' => 'email@email.com'
        ]);

        $id = $response->json('id');
        $customer = Customer::find($id);
        $response
            ->assertStatus(201)
            ->assertJson($customer->toArray());
    }

    public function testCheckIfUpdateFunctionIsWorking()
    {
        $customer = factory(Customer::class)->create([
            'name' => 'test',
            'email' => 'email@email.com'
        ]);

        $response = $this->putJson(
            route('customers.update', ['customer' => $customer->id]),
            [
                'name' => 'test_update'
            ]
        );

        $id = $response->json('id');
        $customer = Customer::find($id);
        $response
            ->assertStatus(200)
            ->assertJson($customer->toArray())
            ->assertJsonFragment([
                'name' => 'test_update'
            ]);
    }

    public function testCheckIfDestroyFunctionIsWorking()
    {
        $customer = factory(Customer::class)->create();

        $response = $this->deleteJson(route('customers.destroy', ['customer' => $customer->id]));
        $response->assertStatus(204);

        $response = $this->deleteJson(route('customers.destroy', ['customer' => $customer->id]));
        $response
            ->assertStatus(404)
            ->assertJsonFragment([
                'message' => "No query results for model [App\Models\Customer] {$customer->id}"
            ]);
    }
}
