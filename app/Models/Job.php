<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employer_id',
        'company_id',
        'category_id',
        'title',
        'slug',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'location',
        'work_type',
        'salary_min',
        'salary_max',
        'application_deadline',
        'is_active',
        'is_approved',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'application_deadline' => 'date',
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    /**
     * Get the employer who posted the job.
     */
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Get the company associated with the job.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the category of the job.
     */
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    /**
     * Get the technologies required for the job.
     */
    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    /**
     * Get the applications for the job.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the comments for the job.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the featured job entry if this job is featured.
     */
    public function featuredJob()
    {
        return $this->hasOne(FeaturedJob::class);
    }

    /**
     * Check if the job is featured.
     */
    public function isFeatured()
    {
        return $this->featuredJob()->exists();
    }

    /**
     * Increment the views count.
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Scope a query to only include active and approved jobs.
     */
    public function scopeActiveAndApproved($query)
    {
        return $query->where('is_active', true)
                    ->where('is_approved', true);
    }
}