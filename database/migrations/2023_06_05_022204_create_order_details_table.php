<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->string('order_detail_code');
            $table->unsignedBigInteger("order_foreign");
            $table->foreign("order_foreign")->references("order_id")->on("orders");
            $table->unsignedBigInteger("product_foreign");
            $table->foreign("product_foreign")->references("product_id")->on("products");
            $table->integer("quantity");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
