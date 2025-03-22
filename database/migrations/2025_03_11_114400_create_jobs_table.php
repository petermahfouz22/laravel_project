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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            // Link to employer who posted the job
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade')
                  ->comment('The employer user who posted this job');
            
            // Link to the company
            $table->foreignId('company_id')->constrained()->onDelete('cascade')
                  ->comment('The company this job belongs to');
            
            // Job category
            $table->foreignId('category_id')->constrained('job_categories')->onDelete('cascade')
                  ->comment('The category this job belongs to');

            $table->string('title')->comment('Job title/position');
            $table->string('slug')->unique()->comment('URL-friendly version of title for routing');
            $table->text('description')->comment('Full job description');
            $table->text('responsibilities')->comment('Job responsibilities and duties');
            $table->text('requirements')->comment('Required skills and qualifications');
            $table->text('benefits')->nullable()->comment('Benefits offered with this position');
            $table->string('location')->comment('Job location');
            
            // Work type with specific options
            $table->enum('work_type', ['remote', 'onsite', 'hybrid'])
                  ->comment('Remote: fully remote, Onsite: in-office only, Hybrid: mix of both');
            
            // Salary range
            $table->decimal('salary_min', 10, 2)->nullable()
                  ->comment('Minimum salary offered');
            $table->decimal('salary_max', 10, 2)->nullable()
                  ->comment('Maximum salary offered');
            
            $table->date('application_deadline')
                  ->comment('Last date for applying to this job');
            
            // Status flags
            $table->boolean('is_active')->default(true)
                  ->comment('Whether this job is currently active (employer can deactivate)');
            $table->boolean('is_approved')->default(false)
                  ->comment('Whether an admin has approved this job listing');
            
            // Analytics counters
            $table->integer('views_count')->default(0)
                  ->comment('Number of times this job has been viewed');
            $table->integer('applications_count')->default(0)
                  ->comment('Number of applications received');
            
            $table->timestamps();
            
            // Indexes for filtering and searching
            $table->index('title');
            $table->index('location');
            $table->index('work_type');
            $table->index(['is_active', 'is_approved']);
            $table->index('application_deadline');
            $table->index('created_at');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
    
};
