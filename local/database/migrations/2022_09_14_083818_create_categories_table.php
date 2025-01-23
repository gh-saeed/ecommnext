<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nameSeo')->nullable();
            $table->string('bodySeo')->nullable();
            $table->string('slug');
            $table->tinyInteger('type');
            $table->string('image',400)->nullable();
            $table->text('body')->nullable();
            $table->string('keyword',400)->nullable();
            $table->timestamps();
        });
        Schema::create('catables', function (Blueprint $table) {
            $table->integer('category_id');
            $table->integer('catables_id');
            $table->string('catables_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
