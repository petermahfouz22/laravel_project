<?php
namespace App\Http\Controllers;

use App\Models\Job; // Ensure this is included
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->take(6)->get(); // Fetch latest 6 jobs
        return view('welcome', compact('jobs')); // Pass $jobs to view
    }
}