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
        Schema::create('company_request_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("company_request_id");
            $table->unsignedBigInteger("product_id");
            $table->integer("quantity")->default(1);
            $table->timestamps();

            $table->foreign("company_request_id")->references('id')->on('company_requests');
            $table->foreign("product_id")->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_request_products');
    }
};
