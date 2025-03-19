<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('jobs', 'salary_range')) {
                $table->string('salary_range')->nullable();
            }
            
            if (!Schema::hasColumn('jobs', 'employment_type')) {
                $table->string('employment_type')->nullable();
            }
            
            if (!Schema::hasColumn('jobs', 'requirements')) {
                $table->text('requirements')->nullable();
            }
            
            if (!Schema::hasColumn('jobs', 'location')) {
                $table->string('location')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn([
                'salary_range',
                'employment_type',
                'requirements',
                'location'
            ]);
        });
    }
}