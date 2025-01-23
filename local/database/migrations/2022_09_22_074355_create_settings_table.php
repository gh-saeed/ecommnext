<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $array = [
            'catHeader',
            'fanavari',
            'etemad',
            'titleSeo',
            'keyword',
            'aboutSeo',
            'number',
            'facebook',
            'instagram',
            'twitter',
            'telegram',
            'logo',
            'about',
            'title',
            'address',
            'productId',
            'name',
            'email',
        ];
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();
        });
        foreach ($array as $item) {
            DB::table('settings')->insert(
                array(
                    'key' => $item,
                    'value' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                )
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
