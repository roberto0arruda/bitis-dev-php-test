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
}
