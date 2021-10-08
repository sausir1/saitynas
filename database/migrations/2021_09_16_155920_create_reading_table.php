<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readings', function (Blueprint $table) {
            $table->primary(['user_id', 'book_id']);
            // $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('book_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->integer('current_page');
            $table->integer('total_pages');
            $table->timestamps();
            $table->date('started_at')->nullable();
            $table->date('finished_at')->nullable();
            $table->boolean('owns')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reading');
    }
}
