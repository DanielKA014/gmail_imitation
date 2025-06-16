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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->references('id')->on('users');
            $table->foreignId('to')->references('id')->on('users');
            $table->string('subject');
            $table->text('body');
            $table->string('file')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
            $table->boolean('is_draft')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
        Schema::table('emails', function(Blueprint $table) {
            $table->dropColumn('is_draft');
        });
    }
};
