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
            $table->id();
            $table->string('name');
            $table->integer('modelNumber');
            $table->integer('package_height');
            $table->integer('package_width');
            $table->integer('package_length');
            $table->integer('package_weight');
            $table->integer('product_height');
            $table->integer('product_width');
            $table->integer('product_length');
            $table->integer('product_weight');
            $table->string('description');
            $table->unsignedBigInteger('brand_id');
            $table->foreign("brand_id")->references('id')->on('brands');
            $table->unsignedBigInteger('product_type_id');
            $table->foreign("product_type_id")->references('id')->on('product_types');
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
