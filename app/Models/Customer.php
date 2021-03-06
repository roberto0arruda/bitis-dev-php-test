<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find($id)
 * @method static create(string[] $array)
 * @method static get(string $string)
 */
class Customer extends Model
{
    use SoftDeletes, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['name', 'email'];

    public function validVouchers()
    {
        return $this->hasMany(Voucher::class)->unused()->notExpired();
    }
}
