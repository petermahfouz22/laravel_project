@extends('layouts.employer')

@section('title', 'Employee Dashboard')

@section('styles')
<style>
    .card-stat {
        transition: transform 0.3s;
    }
    .card-stat:hover {
        transform: translateY(-5px);
    }
</style>
@endsection

@section('header', 'Dashboard')

@section('header-buttons')
<div class="btn-group me-2">
    <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 card-stat">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Attendance This Month</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">90%</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 card-stat">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Leave Balance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">15 days</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar2-minus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 card-stat">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Tasks Completed
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">70%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 card-stat">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Requests</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-bell fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots-vertical"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow">
                <a class="dropdown-item" href="#">View All</a>
                <a class="dropdown-item" href="#">Mark All as Read</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Settings</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Leave request approved</h5>
                    <small>3 days ago</small>
                </div>
                <p class="mb-1">Your leave request for March 25-27 has been approved by your manager.</p>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">New task assigned</h5>
                    <small>1 week ago</small>
                </div>
                <p class="mb-1">You have been assigned to the project "Website Redesign".</p>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Payslip generated</h5>
                    <small>2 weeks ago</small>
                </div>
                <p class="mb-1">Your February payslip is now available for download.</p>
            </a>
        </div>
    </div>
</div>

<!-- Upcoming Events -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Upcoming Events</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Date</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Team Meeting</td>
                                <td>March 23, 2025</td>
                                <td>Conference Room A</td>
                            </tr>
                            <tr>
                                <td>Project Deadline</td>
                                <td>March 28, 2025</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Company Picnic</td>
                                <td>April 15, 2025</td>
                                <td>Central Park</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Task List -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">My Tasks</h6>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="task1">
                            <label class="form-check-label" for="task1">
                                Complete quarterly report
                            </label>
                            <span class="badge bg-danger float-end">High</span>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="task2">
                            <label class="form-check-label" for="task2">
                                Update client presentation
                            </label>
                            <span class="badge bg-warning float-end">Medium</span>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="task3">
                            <label class="form-check-label" for="task3">
                                Schedule team building event
                            </label>
                            <span class="badge bg-info float-end">Low</span>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="" class="btn btn-primary btn-sm">View All Tasks</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Custom script for the dashboard
    $(document).ready(function() {
        // Initialize any dashboard-specific functionality
        console.log('Dashboard loaded');
    });
</script>
@endsection
