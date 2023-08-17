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
        Schema::create('user_request_product_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_request_product_id");
            $table->unsignedBigInteger("item_id");
            $table->timestamps();

            $table->foreign("user_request_product_id")->references('id')->on('user_request_products');
            $table->foreign("item_id")->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_request_product_items');
    }
};
