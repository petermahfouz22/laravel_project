<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'application_id',
        'scheduled_at',
        'duration',
        'location',
        'is_online',
        'meeting_link',
        'notes',
        'completed',
        'outcome_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_online' => 'boolean',
        'completed' => 'boolean',
    ];

    /**
     * Get the application associated with the interview.
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the job through the application.
     */
    public function job()
    {
        return $this->hasOneThrough(Job::class, Application::class, 'id', 'id', 'application_id', 'job_id');
    }

    /**
     * Get the candidate through the application.
     */
    public function candidate()
    {
        return $this->hasOneThrough(User::class, Application::class, 'id', 'id', 'application_id', 'candidate_id');
    }

    /**
     * Scope a query to only include pending interviews.
     */
    public function scopePending($query)
    {
        return $query->where('completed', false)
                    ->where('scheduled_at', '>=', now());
    }

    /**
     * Scope a query to only include completed interviews.
     */
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    /**
     * Scope a query to only include past interviews that are not marked as completed.
     */
    public function scopeMissed($query)
    {
        return $query->where('completed', false)
                    ->where('scheduled_at', '<', now());
    }
}