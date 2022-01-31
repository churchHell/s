<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained();
            $table->integer('pid');
            $table->integer('sid');
            $table->string('name');
            $table->string('url');
            $table->string('img');
            $table->integer('price');
            $table->integer('min_qty');
            $table->string('plural_name_format');
            $table->string('currency', 10);
            $table->foreignId('cart_status_id')->default(1)->constrained();
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
        Schema::dropIfExists('orders');
    }
}
