<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publisher_id')->unsigned();
            $table->foreign('publisher_id')->references("id")->on('publishers');

            $table->integer('publisher_type_id')->unsigned()->default(1);
            $table->foreign('publisher_type_id')->after('congregation_id')->references("id")->on('publisher_types');

            $table->date('date');
            $table->integer('hours')->nullable();
            $table->integer('placements')->nullable();
            $table->integer('videos')->nullable();
            $table->integer('return_visits')->nullable();
            $table->integer('studies')->nullable();
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
        Schema::dropIfExists('field_services');
    }
}
