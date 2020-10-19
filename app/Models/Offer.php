<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(string[] $array)
 * @method static find($id)
 */
class Offer extends Model
{
    use SoftDeletes, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['name', 'discount_percentage', 'expired_at'];

    protected static function booted()
    {
        static::created(function ($offer) {
            $customers = Customer::get('id');

            foreach ($customers as $customer) {
                Voucher::create([
                    'customer_id' => $customer->id,
                    'offer_id' => $offer->id,
                    'expired_at' => $offer->expired_at
                ]);
            }
        });
    }
}
