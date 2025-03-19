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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->dateTime('scheduled_at');
            $table->integer('duration')->comment('في الدقائق');
            $table->string('location')->nullable();
            $table->boolean('is_online')->default(false);
            $table->string('meeting_link')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('completed')->default(false);
            $table->text('outcome_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};