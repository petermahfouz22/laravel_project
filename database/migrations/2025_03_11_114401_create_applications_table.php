<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('applications', function (Blueprint $table) {
        $table->id();
        // Link to the job being applied for
        $table->foreignId('job_id')->constrained()->onDelete('cascade')
              ->comment('The job being applied for');
        
        // Link to the candidate applying
        $table->foreignId('candidate_id')->constrained('users')->onDelete('cascade')
              ->comment('The candidate user applying for the job');
        
        $table->string('resume')->nullable()
              ->comment('Path to the resume file uploaded for this application');
        $table->text('cover_letter')->nullable()
              ->comment('Cover letter or application message');
        
        // Application status with defined states
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')
              ->comment('Pending: awaiting review, Accepted: candidate approved, Rejected: candidate declined');
        
        $table->text('notes')->nullable()
              ->comment('Private notes added by the employer');
        
        $table->timestamps();
        
        // Indexes for filtering applications
        $table->index('status');
        $table->index('created_at');
    });
}

public function down()
{
    Schema::dropIfExists('applications');
}

};
