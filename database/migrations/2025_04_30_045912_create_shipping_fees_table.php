<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('shipping_fees', function (Blueprint $table) {
        $table->id();
        $table->string('province_name');
        $table->string('region'); // Bac, Trung, Nam
        $table->string('carrier'); // GHN, GHTK, ...
        $table->integer('fee'); // phí vận chuyển (đồng)
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_fees');
    }
}
