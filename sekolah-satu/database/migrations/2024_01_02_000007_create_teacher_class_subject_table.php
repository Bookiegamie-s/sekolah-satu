<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("teacher_class_subject", function (Blueprint $table) {
            $table->id();
            $table->foreignId("teacher_id")->constrained()->onDelete("cascade");
            $table->foreignId("class_id")->constrained()->onDelete("cascade");
            $table->foreignId("subject_id")->constrained()->onDelete("cascade");
            $table->timestamps();
            
            $table->unique(["teacher_id", "class_id", "subject_id"]);
        });
    }

    public function down()
    {
        Schema::dropIfExists("teacher_class_subject");
    }
};
