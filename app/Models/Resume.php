<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'type', // e.g., 'general', 'targeted', 'academic'
        'tags', // JSON field for skills or job categories
        'visibility' // 'private', 'public'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
        'tags' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the candidate who owns the resume.
     */
    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Get the formatted file size
     */
    public function getFileSizeAttribute()
    {
        return Storage::exists($this->file_path) 
            ? $this->formatBytes(Storage::size($this->file_path)) 
            : 'N/A';
    }

    /**
     * Format bytes to human-readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Set this resume as the default, and unset all others.
     */
    public function setAsDefault()
    {
        // First, unset all other default resumes for this candidate
        self::where('candidate_id', $this->candidate_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Then set this one as default
        $this->is_default = true;
        $this->save();
    }

    /**
     * Get the download URL for the resume
     */
    public function getDownloadUrlAttribute()
    {
        return route('candidate.resume.download', $this->id);
    }
}