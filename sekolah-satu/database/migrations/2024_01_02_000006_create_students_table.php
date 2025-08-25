<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("students", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("class_id")->constrained()->onDelete("cascade");
            $table->string("student_id")->unique();
            $table->string("parent_name");
            $table->string("parent_phone");
            $table->text("parent_address")->nullable();
            $table->date("enrollment_date");
            $table->enum("status", ["active", "graduated", "dropout", "transferred"])->default("active");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("students");
    }
};
