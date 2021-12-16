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
        Schema::create("books", function (Blueprint $table) {
            $table->increments("id");
            $table->string("book");
            $table->integer("author")->unsigned();
            $table->integer("pages");
            $table->timestamps();
            // $table->foreign("author")->references("id")->on("authors")->onDelete("cascade");
        });

        Schema::table("books", function ($table) {
            $table->foreign("author")->references("id")->on("authors")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("books");
    }
}
