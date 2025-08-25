<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("book_loans", function (Blueprint $table) {
            $table->id();
            $table->string("invoice_number")->unique();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("book_id")->constrained()->onDelete("cascade");
            $table->date("loan_date");
            $table->date("due_date");
            $table->date("return_date")->nullable();
            $table->enum("status", ["borrowed", "returned", "overdue", "lost"]);
            $table->decimal("fine_amount", 10, 2)->default(0);
            $table->text("notes")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("book_loans");
    }
};
