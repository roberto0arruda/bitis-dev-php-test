<?php

namespace Tests\Unit\Models;

use App\Models\Offer;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class OfferTest extends TestCase
{
    private $offer;

    public function testCheckIfOfferAttributesIsCorrect()
    {
        $expected = ['name', 'discount_percentage', 'expired_at'];

        $arrayCompared = array_diff($expected, $this->offer->getFillable());

        $this->assertCount(0, $arrayCompared);
        $this->assertEquals($expected, $this->offer->getFillable());
    }

    public function testCheckIfOfferIsUsingTraits()
    {
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];
        $offerTraits = array_keys(class_uses(Offer::class));
        $this->assertEquals($traits, $offerTraits);
    }

    public function testCheckIfIncrementingAttributeIsFalse()
    {
        $this->assertFalse($this->offer->incrementing);
    }

    public function testCheckIfDatesAttributeIsCorrect()
    {
        $expected = ['deleted_at', 'created_at', 'updated_at'];
        $this->assertIsArray($this->offer->getDates());
        $this->assertCount(count($expected), $this->offer->getDates());
        foreach ($expected as $item) {
            $this->assertContains($item, $this->offer->getDates());
        }

        $this->assertEqualsCanonicalizing($expected, $this->offer->getDates());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->offer = new Offer();
    }
}
