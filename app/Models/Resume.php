<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'candidate_id',
        'title',
        'file_path',
        'is_default',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the candidate who owns the resume.
     */
    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Set this resume as the default, and unset all others.
     */
    public function setAsDefault()
    {
        // First, unset all other default resumes for this candidate
        Resume::where('candidate_id', $this->candidate_id)
              ->where('id', '!=', $this->id)
              ->update(['is_default' => false]);

        // Then set this one as default
        $this->is_default = true;
        $this->save();
    }
}