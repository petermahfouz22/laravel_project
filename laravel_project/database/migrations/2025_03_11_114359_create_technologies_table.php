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
    Schema::create('technologies', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique()->comment('Technology name (e.g., Laravel, React, Python)');
        $table->timestamps();
        
        // Index for faster searches
        $table->index('name');
    });
}

public function down()
{
    Schema::dropIfExists('technologies');
}
};
