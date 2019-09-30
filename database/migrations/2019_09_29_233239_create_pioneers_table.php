<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePioneersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pioneers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('publisher_id')->unsigned();
            $table->foreign('publisher_id')->references("id")->on('publishers');

            $table->integer('service_type_id')->unsigned()->default(1);
            $table->foreign('service_type_id')->references("id")->on('service_types');

            $table->date('start_at');
            $table->date('finish_at')->nullable();

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
        Schema::dropIfExists('pioneers');
    }
}
