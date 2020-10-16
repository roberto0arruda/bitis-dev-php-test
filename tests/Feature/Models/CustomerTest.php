<?php

namespace Tests\Feature\Models;

use App\Models\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseMigrations;

    public function testCheckIfTheCustomerListingIsWorking()
    {
        factory(Customer::class, 2)->create();

        $customers = Customer::all();

        $this->assertCount(2, $customers);

        $customerKeys = array_keys($customers->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $customerKeys
        );
    }

    public function testCheckIfCreatingCustomerIsWorking()
    {
        $customer = Customer::create([
            'name' => 'test1',
            'email' => 'customer@test.com'
        ]);

        $this->assertEquals(36, strlen($customer->id));
        $this->assertEquals('test1', $customer->name);
        $this->assertEquals('customer@test.com', $customer->email);
        $this->assertNull($customer->deleted_at);
    }

    public function testCheckIfUpdateCustomerIsWorking()
    {
        $customer = factory(Customer::class)->create();

        $data = [
            'name' => 'test_updated',
            'email' => 'updated@test.com'
        ];

        $customer->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $customer->{$key});
        }
    }

    public function testCheckIfDeletingCustomerIsWorking()
    {
        $customer = factory(Customer::class)->create();

        $customer->delete();
        $this->assertNull(Customer::find($customer->id));

        $customer->restore();
        $this->assertNotNull(Customer::find($customer->id));
    }
}
