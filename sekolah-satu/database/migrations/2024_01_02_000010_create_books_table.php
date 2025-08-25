<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("books", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("author");
            $table->string("isbn")->unique();
            $table->string("publisher")->nullable();
            $table->year("publication_year")->nullable();
            $table->string("category");
            $table->text("description")->nullable();
            $table->integer("total_copies");
            $table->integer("available_copies");
            $table->string("shelf_location")->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("books");
    }
};
