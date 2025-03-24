<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('candidate.dashboard');
    }
}