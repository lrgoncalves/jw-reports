<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublishersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('householder_id')->nullable()->unsigned();
            $table->foreign('householder_id')->references("id")->on('publishers');

            $table->string('name', 60);
            $table->date('birthdate')->nullable();
            $table->date('baptize_date')->nullable();
            $table->integer('pioneer_code')->nullable();
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
        Schema::dropIfExists('publishers');
    }
}
