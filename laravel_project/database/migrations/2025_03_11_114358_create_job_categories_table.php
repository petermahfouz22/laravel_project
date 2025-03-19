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
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Category name (e.g., Programming, Management, Marketing)');
            $table->string('slug')->unique()->comment('URL-friendly version of the name for routing');
            $table->text('description')->nullable()->comment('Description of this job category');
            $table->timestamps();
            
            // Indexes for quick lookups
            $table->index('name');
            $table->index('slug');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('job_categories');
    }
    
};
