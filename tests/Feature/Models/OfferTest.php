<?php

namespace Tests\Feature\Models;

use App\Models\Offer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OfferTest extends TestCase
{
    use DatabaseMigrations;

    public function testCheckIfTheOfferListingIsWorking()
    {
        factory(Offer::class, 2)->create();

        $offers = Offer::all();

        $this->assertCount(2, $offers);

        $offerKeys = array_keys($offers->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'discount_percentage',
                'expired_at',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $offerKeys
        );
    }

    public function testCheckIfCreatingOfferIsWorking()
    {
        $offer = Offer::create([
            'name' => 'test1',
            'discount_percentage' => 20,
            'expired_at' => now()
        ]);

        $this->assertEquals(36, strlen($offer->id));
        $this->assertEquals('test1', $offer->name);
        $this->assertEquals(20, $offer->discount_percentage);
        $this->assertNull($offer->deleted_at);
    }

    public function testCheckIfUpdateOfferIsWorking()
    {
        $offer = factory(Offer::class)->create();

        $data = [
            'name' => 'test_updated'
        ];

        $offer->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $offer->{$key});
        }
    }

    public function testCheckIfDeletingOfferIsWorking()
    {
        $offer = factory(Offer::class)->create();

        $offer->delete();
        $this->assertNull(Offer::find($offer->id));

        $offer->restore();
        $this->assertNotNull(Offer::find($offer->id));
    }
}
