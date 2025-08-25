<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("teachers", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("employee_id")->unique();
            $table->string("specialization")->nullable();
            $table->integer("max_jam_mengajar")->default(24); // jam per minggu
            $table->date("hire_date");
            $table->decimal("salary", 12, 2)->nullable();
            $table->text("qualifications")->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("teachers");
    }
};
