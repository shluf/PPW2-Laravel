<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('review', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buku_id');
            $table->unsignedBigInteger('reviewer_id');
            $table->string('review');
            $table->timestamps();

            $table->foreign('buku_id')
            ->references('id')
            ->on('books')
            ->onDelete('cascade');

            $table->foreign('reviewer_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });

        Schema::create('tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->string('tag');
            $table->timestamps();

            $table->foreign('review_id')
            ->references('id')
            ->on('review')
            ->onDelete('cascade');
        });

        Schema::create('review_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('review_id')
            ->references('id')
            ->on('review')
            ->onDelete('cascade');

            $table->foreign('tag_id')
            ->references('id')
            ->on('tag')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag');
        Schema::dropIfExists('review');
    }
};
