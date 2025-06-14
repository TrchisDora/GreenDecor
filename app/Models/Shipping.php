<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Shipping extends Model
{
    protected $fillable=['type','name','status'];
    public function fee()
    {
        return $this->hasMany(ShippingFee::class, 'shipping_id', 'id');
    }

}

