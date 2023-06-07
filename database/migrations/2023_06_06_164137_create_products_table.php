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
            $table->integer('model_number');
            $table->float('package_height');
            $table->float('package_width');
            $table->float('package_length');
            $table->float('package_weight');
            $table->float('product_height');
            $table->float('product_width');
            $table->float('product_length');
            $table->float('product_weight');
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
