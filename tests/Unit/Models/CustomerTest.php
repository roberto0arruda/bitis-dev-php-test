<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    private $customer;

    public function testCheckIfCustomerAttributesIsCorrect()
    {
        $expected = ['name', 'email'];

        $arrayCompared = array_diff($expected, $this->customer->getFillable());

        $this->assertCount(0, $arrayCompared);
        $this->assertEquals($expected, $this->customer->getFillable());
    }

    public function testCheckIfCustomerIsUsingTraits()
    {
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];
        $customerTraits = array_keys(class_uses(Customer::class));
        $this->assertEquals($traits, $customerTraits);
    }

    public function testCheckIfIncrementingAttributeIsFalse()
    {
        $this->assertFalse($this->customer->incrementing);
    }

    public function testCheckIfDatesAttributeIsCorrect()
    {
        $expected = ['deleted_at', 'created_at', 'updated_at'];
        $this->assertIsArray($this->customer->getDates());
        $this->assertCount(count($expected), $this->customer->getDates());
        foreach ($expected as $item) {
            $this->assertContains($item, $this->customer->getDates());
        }

        $this->assertEqualsCanonicalizing($expected, $this->customer->getDates());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = new Customer();
    }
}
