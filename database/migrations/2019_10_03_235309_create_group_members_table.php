<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_members', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('group_id')->unsigned();
            $table->foreign('group_id')->references("id")->on('groups');

            $table->integer('publisher_id')->unsigned();
            $table->foreign('publisher_id')->references("id")->on('publishers');

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
        Schema::dropIfExists('group_members');
    }
}
