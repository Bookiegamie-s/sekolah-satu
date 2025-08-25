<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("schedules", function (Blueprint $table) {
            $table->id();
            $table->foreignId("teacher_id")->constrained()->onDelete("cascade");
            $table->foreignId("class_id")->constrained()->onDelete("cascade");
            $table->foreignId("subject_id")->constrained()->onDelete("cascade");
            $table->enum("day_of_week", ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday"]);
            $table->time("start_time");
            $table->time("end_time");
            $table->string("room")->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
            
            $table->index(["teacher_id", "day_of_week", "start_time"]);
            $table->index(["class_id", "day_of_week", "start_time"]);
        });
    }

    public function down()
    {
        Schema::dropIfExists("schedules");
    }
};
