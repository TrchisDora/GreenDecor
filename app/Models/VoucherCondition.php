<?php

// app/Models/VoucherCondition.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherCondition extends Model
{
    protected $fillable = ['voucher_id', 'condition_key', 'condition_operator', 'condition_value'];

    // Mối quan hệ với Coupon
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
