<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_products', function (Blueprint $table) {
            $table->id();
            $table->string('unique_key')->unique();

            $table->unsignedBigInteger('sales_id');
            $table->foreign('sales_id')->references('id')->on('sales')->onDelete('cascade');

            $table->unsignedBigInteger('productlist_id');
            $table->foreign('productlist_id')->references('id')->on('productlists')->onDelete('cascade');

            $table->string('bag')->nullable();
            $table->string('kgs')->nullable();
            $table->string('price_per_kg')->nullable();
            $table->string('total_price')->nullable();
            $table->string('status')->default(0);
            $table->boolean('soft_delete')->default(0);
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
        Schema::dropIfExists('sales_products');
    }
};