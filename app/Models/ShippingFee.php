<?php

// app/Models/ShippingFee.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    protected $table = 'shipping_fees';
    protected $fillable = ['province_name','region', 'shipping_fees', 'price'];

    public $timestamps = false;
    public function shipping()
{
    return $this->belongsTo(Shipping::class, 'shipping_id', 'id');
}

}
