<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('full_name')->nullable();
            $table->string('pen_name')->nullable();
            $table->string('handle')->nullable();
            $table->string('role');
            $table->string('photo')->nullable();
            $table->text('short_bio')->nullable();
            $table->json('biography')->nullable();
            $table->json('quotes')->nullable();
            $table->json('awards')->nullable();
            $table->json('facts')->nullable();
            $table->integer('works')->default(0);
            $table->string('born_date')->nullable();
            $table->string('born_city')->nullable();
            $table->string('born_country')->nullable();
            $table->string('died_date')->nullable();
            $table->string('died_city')->nullable();
            $table->string('died_country')->nullable();
            $table->string('burial_place')->nullable();
            $table->string('nationality')->nullable();
            $table->string('era')->nullable();
            $table->string('occupation')->nullable();
            $table->string('genre')->nullable();
            $table->string('education')->nullable();
            $table->string('spouse')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};