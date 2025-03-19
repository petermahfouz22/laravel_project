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
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        // Link to the user who made the comment
        $table->foreignId('user_id')->constrained()->onDelete('cascade')
              ->comment('The user who created this comment');
        
        // Polymorphic relationship (typically for jobs)
        $table->morphs('commentable');
        
        $table->text('content')->comment('The comment text content');
        $table->boolean('is_approved')->default(true)
              ->comment('Whether this comment is approved or has been moderated');
        
        $table->timestamps();
        
        // Index for filtering comments by approval status
        $table->index('is_approved');
    });
}

public function down()
{
    Schema::dropIfExists('comments');
}

};
