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
        Schema::create('job_technology', function (Blueprint $table) {
            // Links job with technology
            $table->foreignId('job_id')->constrained()->onDelete('cascade')
                  ->comment('Reference to the job');
            $table->foreignId('technology_id')->constrained()->onDelete('cascade')
                  ->comment('Reference to the technology');
            
            // Composite primary key
            $table->primary(['job_id', 'technology_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('job_technology');
    }
    
};
