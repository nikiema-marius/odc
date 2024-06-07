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
        Schema::create('formation_participant', function (Blueprint $table) {
            $table->unsignedBigInteger('formation_id');
            $table->unsignedBigInteger('participant_id');
            $table->primary(['formation_id', 'participant_id']);

            $table->foreign('formation_id')->references('id')->on('formations')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formation__participants');
    }
};
