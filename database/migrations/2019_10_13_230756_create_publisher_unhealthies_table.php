<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublisherUnhealthiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publisher_unhealthies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publisher_id')->unsigned();
            $table->foreign('publisher_id')->references("id")->on('publishers');
            $table->date('start_at')->nullable();
            
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
        Schema::dropIfExists('publisher_unhealthies');
    }
}
