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
    Schema::create('companies', function (Blueprint $table) {
        $table->id();
        // Link to employer user - only employer role users will have companies
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')
              ->comment('Link to the employer user who owns this company');
        $table->string('name')->comment('Company name');
        $table->text('description')->comment('Detailed company description');
        $table->string('logo')->nullable()->comment('Path to company logo image');
        $table->string('website')->nullable()->comment('Company website URL');
        $table->string('location')->comment('Company headquarters or primary location');
        $table->string('industry')->comment('Industry sector the company operates in');
        $table->string('size')->nullable()->comment('Company size (e.g., 1-10, 11-50, 51-200, etc.)');
        $table->integer('founded_year')->nullable()->comment('Year the company was founded');
        $table->timestamps();
        
        // Index on industry for filtering jobs by industry
        $table->index('industry');
    });
}

public function down()
{
    Schema::dropIfExists('companies');
}

};
