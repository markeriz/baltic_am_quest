<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressBookSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_book_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_book_id')->references('id')->on('address_books');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_book_shares');
    }
}
