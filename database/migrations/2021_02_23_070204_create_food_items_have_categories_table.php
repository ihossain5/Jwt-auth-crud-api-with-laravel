<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodItemsHaveCategoriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('food_items_have_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('food_item_id')->unsigned();
            $table->bigInteger('food_item_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('food_item_id')->references('id')->on('food_items')
                ->onDelete('cascade');

            $table->foreign('food_item_category_id')->references('id')->on('food_item_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('food_items_have_categories');
    }
}
