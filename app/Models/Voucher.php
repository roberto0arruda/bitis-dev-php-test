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

    public $incrementing = false;

    protected $primaryKey = 'code';

    protected $fillable = ['customer_id', 'offer_id', 'expired_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->code = RamseyUuid::uuid4()->toString();
        });
    }

    public function scopeNotExpired($query)
    {
        return $query->where('expired_at', '>=', now()->format('Y-m-d'));
    }

    public function scopeUnused($query)
    {
        return $query->where('used_at', NULL);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
