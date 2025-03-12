<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_id',
        'candidate_id',
        'resume',
        'cover_letter',
        'status',
        'notes',
    ];

    /**
     * Get the job being applied for.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the candidate who applied.
     */
    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }
}
