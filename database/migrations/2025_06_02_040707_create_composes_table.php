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
        Schema::create('composes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesan_id');
            $table->string('kepada');
            $table->string('subjek');
            $table->text('pesan');
            $table->string('file');

            $table->foreign('pesan_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('composes');
    }
};
