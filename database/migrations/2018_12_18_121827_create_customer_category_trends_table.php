<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCategoryTrendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_category_trends', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references("id")->on('products');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references("id")->on('categories');

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references("id")->on('customers');

            $table->date('date');

            $table->bigInteger('total')->unsigned();

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
        Schema::dropIfExists('customer_category_trends');
    }
}
