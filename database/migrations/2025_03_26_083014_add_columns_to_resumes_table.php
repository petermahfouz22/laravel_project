<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('resumes', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('resumes', 'type')) {
                $table->string('type')->nullable()->after('file_path');
            }

            if (!Schema::hasColumn('resumes', 'tags')) {
                $table->json('tags')->nullable()->after('type');
            }

            if (!Schema::hasColumn('resumes', 'visibility')) {
                $table->enum('visibility', ['private', 'public'])->default('private')->after('tags');
            }
        });
    }

    public function down()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn(['type', 'tags', 'visibility']);
        });
    }
};