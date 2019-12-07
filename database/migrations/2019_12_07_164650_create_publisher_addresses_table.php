<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublisherAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publisher_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('publisher_id')->unsigned();
            $table->foreign('publisher_id')->references("id")->on('publishers');

            $table->string('address');
            $table->string('address_2')->nullable();
            $table->string('number', 45);
            $table->string('neighborhood', 60);
            $table->string('city', 60);
            $table->string('state', 5);
            $table->string('zipcode', 10);
            
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
        Schema::dropIfExists('publisher_addresses');
    }
}
