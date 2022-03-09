<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 20);
            $table->string('title', 255);
            $table->tinyInteger('owned')->unsigned()->default(0);
            $table->tinyInteger('completed')->unsigned()->default(0);
            $table->string('genre_id', 20);
            $table->string('writer_id', 20);
            $table->integer('user_id')->unsigned()->default(1);
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
        Schema::dropIfExists('books');
    }
}
