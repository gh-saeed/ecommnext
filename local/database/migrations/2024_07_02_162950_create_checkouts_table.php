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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_ip',20)->nullable();
            $table->bigInteger('card')->nullable();
            $table->string('shaba',24)->nullable();
            $table->string('name',50)->nullable();
            $table->tinyInteger('type')->nullable();
            $table->bigInteger('price')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->bigInteger('property')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
