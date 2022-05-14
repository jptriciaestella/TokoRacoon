<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("user_id")->unsigned();
            $table->integer('tax')->unsigned();
            $table->integer('total')->unsigned();

            $table->string('name_address');
            $table->string('address');
            $table->integer('postal_code')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
