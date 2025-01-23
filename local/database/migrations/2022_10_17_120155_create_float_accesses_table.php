<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloatAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('float_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default(0)->nullable();
            $table->string('link')->default(0)->nullable();
            $table->tinyInteger('type')->default(0)->nullable();
            $table->tinyInteger('icon')->default(0)->nullable();
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
        Schema::dropIfExists('float_accesses');
    }
}
