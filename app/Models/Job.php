<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id', 'company_id', 'category_id', 'title', 'slug', 'description',
        'responsibilities', 'requirements', 'benefits', 'location', 'work_type',
        'salary_min', 'salary_max', 'application_deadline', 'is_active', 'is_approved',
    ];

    protected $casts = [
        'application_deadline' => 'date',
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'job_technology'); // Specify pivot table
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function featuredJob()
    {
        return $this->hasOne(FeaturedJob::class);
    }

    // Add this for saved jobs
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_jobs', 'job_id', 'user_id')
                    ->withTimestamps();
    }

    public function isFeatured()
    {
        return $this->featuredJob()->exists();
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function scopeActiveAndApproved($query)
    {
        return $query->where('is_active', true)->where('is_approved', true);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%"));

        $query->when($filters['location'] ?? false, fn($query, $location) =>
            $query->where('location', 'like', "%{$location}%"));

        $query->when($filters['work_type'] ?? false, fn($query, $work_type) =>
            $query->where('work_type', $work_type));

        $query->when($filters['category_id'] ?? false, fn($query, $category_id) =>
            $query->where('category_id', $category_id));
    }
}