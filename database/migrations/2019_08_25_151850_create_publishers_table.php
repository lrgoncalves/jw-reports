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

            $table->bigInteger('group_id')->nullable()->unsigned();
            $table->foreign('group_id')->references("id")->on('groups');

            $table->string('name', 60);
            $table->string('gender', 1)->default('F');
            $table->date('birthdate')->nullable();
            $table->date('baptize_date')->nullable();
            $table->tinyInteger('anointed')->default(0);
            $table->string('privilege', 2)->nullable();
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
