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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('manufacturer_foreign');
            $table->foreign('manufacturer_foreign')->references('manufacturer_id')->on('manufacturers');
            $table->unsignedBigInteger('type_foreign');
            $table->foreign('type_foreign')->references('type_id')->on('types');
            $table->integer('base_price');
            $table->integer('sell_price');
            $table->double('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
