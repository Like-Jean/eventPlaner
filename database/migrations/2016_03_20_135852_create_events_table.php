<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('host_id')->unsigned()->index();
            $table->foreign('host_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('type');
            $table->string('place');
            $table->string('description');
            $table->datetime('beginTime');
            $table->boolean('isCanceled');
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
        Schema::drop('events');
    }
}
