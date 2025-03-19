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
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        // Link to user - cascade delete ensures profile is removed if user is deleted
        $table->foreignId('user_id')->constrained()->onDelete('cascade')
              ->comment('Link to the user this profile belongs to');
        $table->text('bio')->nullable()->comment('User biography or introduction');
        $table->string('location')->nullable()->comment('User\'s geographic location');
        $table->string('phone')->nullable()->comment('Contact phone number');
        $table->string('profile_image')->nullable()->comment('Path to profile picture');
        $table->string('linkedin_url')->nullable()->comment('LinkedIn profile URL');
        $table->string('website')->nullable()->comment('Personal website URL');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('profiles');
}

};
