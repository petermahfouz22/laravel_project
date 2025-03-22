<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', // Include slug from your migration
    ];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_technology'); // Specify pivot table
    }

    // Add this for profile skills
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_technology', 'technology_id', 'profile_id');
    }
}