<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid as RamseyUuid;

/**
 * @method static create(array $array)
 */
class Voucher extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'code';

    protected $fillable = ['customer_id', 'offer_id', 'expired_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->code = RamseyUuid::uuid4()->toString();
        });
    }
}
