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

            $table->integer('year_service_id')->unsigned();
            $table->foreign('year_service_id')->references("id")->on('year_services');

            $table->integer('service_type_id')->unsigned()->default(1);
            $table->foreign('service_type_id')->references("id")->on('service_types');

            $table->integer('month')->nullable();
            $table->integer('placements')->nullable();
            $table->integer('videos')->nullable();
            $table->integer('hours')->nullable();
            $table->integer('return_visits')->nullable();
            $table->integer('studies')->nullable();

            $table->string('observations', 255)->nullable();
            $table->date('date_ref')->nullable();

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
