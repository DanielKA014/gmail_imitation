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
        Schema::create('drafts_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Pengirim (relasi ke users)
            $table->string('to')->nullable();      // Penerima (boleh kosong saat draft)
            $table->string('subject')->nullable(); // Subjek email
            $table->text('message')->nullable();   // Isi email
            $table->string('image')->nullable();   // Path file lampiran
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drafts_emails');
    }
};
