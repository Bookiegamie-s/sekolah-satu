<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->string("phone")->nullable()->after("email");
            $table->text("address")->nullable()->after("phone");
            $table->date("birth_date")->nullable()->after("address");
            $table->enum("gender", ["male", "female"])->nullable()->after("birth_date");
            $table->string("avatar")->nullable()->after("gender");
            $table->boolean("is_active")->default(true)->after("avatar");
        });
    }

    public function down()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn(["phone", "address", "birth_date", "gender", "avatar", "is_active"]);
        });
    }
};
