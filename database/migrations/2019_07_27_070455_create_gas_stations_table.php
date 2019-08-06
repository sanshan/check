<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGasStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gas_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('restrict');
            $table->unSignedBigInteger('type_of_gas_station_id');
            $table->foreign('type_of_gas_station_id')->references('id')->on('type_of_gas_stations')->onDelete('restrict');
            $table->integer('number')->unique();
            $table->string('address', 500);
            $table->boolean('is_shop');
            $table->boolean('it_works');
            $table->string('dir_name', 20);
            $table->string('dir_patronymic', 20);
            $table->string('dir_surname', 20);
            $table->string('email', 50);
            $table->string('phone', 50);
            $table->softDeletes();
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
        Schema::dropIfExists('gas_stations');
    }
}
