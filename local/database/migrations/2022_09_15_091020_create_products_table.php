<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('image');
            $table->string('slug');
            $table->smallInteger('count');
            $table->smallInteger('prepare');
            $table->bigInteger('time');
            $table->smallInteger('type')->default(0);
            $table->boolean('inquiry')->default(0);
            $table->string('product_id' , 15);
            $table->boolean('status')->default(0);
            $table->string('score',50)->nullable();
            $table->boolean('showcase')->default(0);
            $table->boolean('original')->default(0);
            $table->boolean('used')->default(0);
            $table->string('off' , 3)->nullable();
            $table->string('weight' , 10)->nullable();
            $table->text('body')->nullable();
            $table->string('user_id' , 10)->default(1);
            $table->integer('price');
            $table->integer('offPrice')->nullable();
            $table->text('ability')->nullable();
            $table->text('size')->nullable();
            $table->text('colors')->nullable();
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
        Schema::dropIfExists('products');
    }
}
