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
        Schema::create('featured_jobs', function (Blueprint $table) {
            $table->id();
            // Link to the featured job
            $table->foreignId('job_id')->constrained()->onDelete('cascade')
                  ->comment('The job being featured');
            
            $table->integer('priority')->default(0)
                  ->comment('Display priority/order in the slider (higher = more prominent)');
            
            $table->date('start_date')->comment('Date when featuring begins');
            $table->date('end_date')->comment('Date when featuring ends');
            
            $table->timestamps();
            
            // Indexes for active featured jobs
            $table->index(['start_date', 'end_date']);
            $table->index('priority');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('featured_jobs');
    }
    
};
