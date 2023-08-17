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
        Schema::create('company_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("company_to_id");
            $table->unsignedBigInteger("company_from_id");
            $table->unsignedBigInteger('request_status_id');
            $table->timestamps();

            $table->foreign("company_to_id")->references('id')->on('companies');
            $table->foreign("company_from_id")->references('id')->on('companies');
            $table->foreign("request_status_id")->references('id')->on('request_statuses');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_requests');
    }
};
