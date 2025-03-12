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
    Schema::create('resumes', function (Blueprint $table) {
        $table->id();
        // Link to candidate user
        $table->foreignId('candidate_id')->constrained('users')->onDelete('cascade')
              ->comment('The candidate who owns this resume');
        
        $table->string('title')->comment('Resume title/name for identification');
        $table->string('file_path')->comment('Path to the resume file on storage');
        $table->boolean('is_default')->default(false)
              ->comment('Whether this is the candidate\'s default resume for applications');
        
        $table->timestamps();
        
        // Ensure only one default resume per candidate
        $table->index(['candidate_id', 'is_default']);
    });
}

public function down()
{
    Schema::dropIfExists('resumes');
}

};
