<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("authors", function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->bigInteger("user_id")->unsigned();
            $table->timestamps();
        });

        Schema::table("authors", function ($table) {
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("authors");
    }
}
