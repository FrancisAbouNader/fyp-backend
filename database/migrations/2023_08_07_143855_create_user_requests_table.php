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
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("company_id")->nullable();
            $table->unsignedBigInteger("request_status_id");
            $table->timestamps();

            $table->foreign("user_id")->references('id')->on('users');
            $table->foreign("company_id")->references('id')->on('companies');
            $table->foreign("request_status_id")->references('id')->on('request_statuses');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_requests');
    }
};
