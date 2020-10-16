<?php

namespace Tests\Unit\Models;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class VoucherTest extends TestCase
{
    private $voucher;

    public function testCheckIfVoucherAttributesIsCorrect()
    {
        $expected = ['customer_id', 'offer_id', 'expired_at'];

        $arrayCompared = array_diff($expected, $this->voucher->getFillable());

        $this->assertCount(0, $arrayCompared);
        $this->assertEquals($expected, $this->voucher->getFillable());

    }

    public function testCheckIfOfferIsUsingTraits()
    {
        $traits = [SoftDeletes::class];
        $offerTraits = array_keys(class_uses(Voucher::class));
        $this->assertEquals($traits, $offerTraits);
    }

    public function testCheckIfDatesAttributeIsCorrect()
    {
        $expected = ['deleted_at', 'created_at', 'updated_at'];
        $this->assertIsArray($this->voucher->getDates());
        $this->assertCount(count($expected), $this->voucher->getDates());
        foreach ($expected as $item) {
            $this->assertContains($item, $this->voucher->getDates());
        }

        $this->assertEqualsCanonicalizing($expected, $this->voucher->getDates());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->voucher = new Voucher();
    }
}
