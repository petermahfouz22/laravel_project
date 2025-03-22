<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id', 'title', 'file_path', 'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function setAsDefault()
    {
        Resume::where('candidate_id', $this->candidate_id)
              ->where('id', '!=', $this->id)
              ->update(['is_default' => false]);
        $this->is_default = true;
        $this->save();
    }
}