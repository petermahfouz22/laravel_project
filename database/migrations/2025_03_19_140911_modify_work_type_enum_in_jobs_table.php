<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // MySQL allows you to modify ENUM values directly
        DB::statement("ALTER TABLE jobs MODIFY COLUMN work_type ENUM('remote', 'onsite', 'hybrid', 'full-time', 'part-time', 'contract', 'freelance', 'internship')");
    }

    public function down()
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE jobs MODIFY COLUMN work_type ENUM('remote', 'onsite', 'hybrid')");
    }
};