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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        // Role determines permissions and accessible features
        $table->enum('role', ['admin', 'employer', 'candidate'])
            ->comment('Admin: platform management, Employer: posts jobs, Candidate: applies to jobs');
        $table->rememberToken();
        $table->timestamps();
        
        // Index on role for efficient filtering
        $table->index('role');
    });
}

public function down()
{
    Schema::dropIfExists('users');
}


};
