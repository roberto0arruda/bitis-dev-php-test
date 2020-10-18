<?php

namespace Tests\Feature\Http\Controllers\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CustomerRequestValidationTest extends TestCase
{
    use DatabaseMigrations;

    public function testCheckIfFieldsIsRequired()
    {
        $response = $this->postJson(route('customers.store'));

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'email'
            ])
            ->assertExactJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.']
                ]
            ])
            ->assertJsonCount(2, 'errors');
    }

    public function testCustomerEmailShouldBeUnique()
    {
        factory(Customer::class)->create([
            'name' => 'Cliente 1',
            'email' => 'cliente@email.com'
        ]);
        $response = $this->postJson(route('customers.store'), [
            'name' => 'Cliente 1',
            'email' => 'cliente@email.com'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email'
            ])
            ->assertExactJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email has already been taken.']
                ]
            ])
            ->assertJsonCount(1, 'errors');
    }
}
