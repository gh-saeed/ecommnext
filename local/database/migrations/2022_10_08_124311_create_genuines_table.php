<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenuinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genuines', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('gender')->nullable();
            $table->bigInteger('post')->nullable();
            $table->string('address')->nullable();
            $table->string('residenceAddress',250)->nullable();
            $table->bigInteger('code')->nullable();
            $table->string('job' , 50)->nullable();
            $table->string('date' , 11)->nullable();
            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('genuines');
    }
}
