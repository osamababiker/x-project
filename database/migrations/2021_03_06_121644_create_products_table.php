<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->double('price');
            $table->double('selling_price');
            $table->json('product_specification');
            $table->json('colors');
            $table->json('size');
            $table->text('description');

            $table->integer('status')->default(1);
            $table->integer('is_deleted')->default(0);

            $table->integer('category_id')->unsigned();
            $table->integer('vendor_id')->unsigned();
            $table->integer('factory_id')->unsigned();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
            $table->foreign('vendor_id')
                   ->references('id')
                   ->on('vendors')
                   ->onDelete('cascade');
            $table->foreign('factory_id')
                    ->references('id')
                    ->on('factories')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
