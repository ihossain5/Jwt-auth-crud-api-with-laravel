<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemStocksTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('item_stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('food_item_id')->unsigned();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('food_item_id')->references('id')->on('food_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('item_stocks');
    }
}
