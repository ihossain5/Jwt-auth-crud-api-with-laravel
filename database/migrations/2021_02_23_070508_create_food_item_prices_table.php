<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodItemPricesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('food_item_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('food_item_id')->unsigned();
            $table->integer('original_price');
            $table->integer('discounted_price')->nullable();
            $table->string('discount_type')->nullable();
            $table->integer('fixed_value')->nullable();
            $table->integer('percent_of')->nullable();
            $table->timestamps();

            $table->foreign('food_item_id')->references('id')->on('food_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('food_item_prices');
    }
}
