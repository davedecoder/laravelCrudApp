<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('clients', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->string('second_last_name');
            $table->string('email')->unique();
            $table->date('birth');
            $table->string('birth_state');
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
        //
        Schema::drop('clients');
    }
}
