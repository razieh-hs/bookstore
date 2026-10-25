<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->string('author_id');
            $table->string('genre');
            $table->integer('price');
            $table->integer('old')->nullable();
            $table->float('rating');
            $table->integer('reviews');
            $table->integer('year');
            $table->integer('pages');
            $table->string('publisher');
            $table->text('desc');
            $table->longText('desc_long')->nullable();
            $table->string('cover')->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};