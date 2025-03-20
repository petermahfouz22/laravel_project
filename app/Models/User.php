<?php

namespace App\Models;

<<<<<<< HEAD
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
=======
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
>>>>>>> a8ef134669f78db1c3426dba217de3914161e0ee

    /**
     * The attributes that are mass assignable.
     *
<<<<<<< HEAD
     * @var list<string>
=======
     * @var array<int, string>
>>>>>>> a8ef134669f78db1c3426dba217de3914161e0ee
     */
    protected $fillable = [
        'name',
        'email',
        'password',
<<<<<<< HEAD
=======
        'role',
>>>>>>> a8ef134669f78db1c3426dba217de3914161e0ee
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
<<<<<<< HEAD
     * @var list<string>
=======
     * @var array<int, string>
>>>>>>> a8ef134669f78db1c3426dba217de3914161e0ee
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
<<<<<<< HEAD
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
=======
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the profile associated with the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the company associated with the employer user.
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    /**
     * Get the jobs posted by the employer user.
     */
    public function postedJobs()
    {
        return $this->hasMany(Job::class, 'employer_id');
    }

    /**
     * Get the applications submitted by the candidate user.
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'candidate_id');
    }

    /**
     * Get the resumes owned by the candidate user.
     */
    public function resumes()
    {
        return $this->hasMany(Resume::class, 'candidate_id');
    }

    /**
     * Get the comments made by the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is an employer.
     */
    public function isEmployer()
    {
        return $this->role === 'employer';
    }

    /**
     * Check if the user is a candidate.
     */
    public function isCandidate()
    {
        return $this->role === 'candidate';
    }
}
>>>>>>> a8ef134669f78db1c3426dba217de3914161e0ee
