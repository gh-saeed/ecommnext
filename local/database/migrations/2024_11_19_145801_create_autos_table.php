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
        Schema::create('autos', function (Blueprint $table) {
            $table->id();
            $table->string('link')->nullable()->default(0);
            $table->boolean('status')->nullable()->default(0);
            $table->boolean('type')->nullable()->default(0);
            $table->bigInteger('user_id')->nullable()->default(0);
            $table->bigInteger('link_page')->nullable()->default(0);
            $table->bigInteger('link_paginate')->nullable()->default(0);
            $table->bigInteger('page')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autos');
    }
};
