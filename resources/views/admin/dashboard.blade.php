<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <!-- Assuming Bootstrap and Font Awesome are included -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    .dropdown {
      position: relative;
      display: inline-block;
      margin-right: 15px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 120px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1000;
      right: 0;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown .dropbtn {
      text-decoration: none;
    }

    .dropdown:hover .dropbtn {
      background-color: #0056b3;
      color: white;
      border-color: #0056b3;
    }

    .icon-circle {
      height: 2.5rem;
      width: 2.5rem;
      border-radius: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 2px;
    }

    .activity-feed .feed-item {
      position: relative;
    }

    .activity-feed .feed-item:not(:last-child):after {
      content: '';
      position: absolute;
      left: 1.25rem;
      top: 2.5rem;
      bottom: -1rem;
      width: 2px;
      background-color: #e3e6f0;
    }

    .border-left-primary {
      border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
      border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-info {
      border-left: 0.25rem solid #36b9cc !important;
    }

    .border-left-warning {
      border-left: 0.25rem solid #f6c23e !important;
    }

    .chart-area {
      position: relative;
      height: 20rem;
    }

    .chart-pie {
      position: relative;
      height: 15rem;
    }
  </style>
</head>

<body>
  <div class="container-fluid px-4">
    <!-- Dashboard Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <div class="d-flex align-items-center">
        <!-- Signup Dropdown -->
        <div class="dropdown">
          <a href="#" class="dropbtn btn btn-outline-primary btn-sm">Signup</a>
        </div>

        <!-- Login Dropdown -->
        <div class="dropdown">
          <a href="#" class="dropbtn btn btn-outline-primary btn-sm">Login</a>
          <div class="dropdown-content">
            <a href="#">Candidate</a>
            <a href="#">Employer</a>
          </div>
        </div>

        <a href="#" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Add New Job
        </a>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
      <!-- Active Jobs -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                  Active Jobs</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">25</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-briefcase fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent border-0 text-end">
            <a href="#" class="small text-primary">View Details</a>
          </div>
        </div>
      </div>

      <!-- Total Employers -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                  Total Employers</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-building fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent border-0 text-end">
            <a href="#" class="small text-success">View Details</a>
          </div>
        </div>
      </div>

      <!-- Registered Candidates -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                  Registered Candidates</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">150</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent border-0 text-end">
            <a href="#" class="small text-info">View Details</a>
          </div>
        </div>
      </div>

      <!-- Total Applications -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                  Job Applications</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">85</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent border-0 text-end">
            <a href="#" class="small text-warning">View Details</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card shadow">
          <div class="card-header">Recent Activities</div>
          <div class="card-body activity-feed">
            <div class="feed-item d-flex align-items-center mb-3">
              <div class="icon-circle bg-primary text-white me-3"><i class="fas fa-briefcase"></i></div>
              <div>New job "Software Engineer" posted - 5 mins ago</div>
            </div>
            <div class="feed-item d-flex align-items-center mb-3">
              <div class="icon-circle bg-success text-white me-3"><i class="fas fa-building"></i></div>
              <div>Employer "TechCorp" registered - 10 mins ago</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
          <div class="card-header">Job Applications Over Time</div>
          <div class="card-body">
            <div class="chart-area"><canvas id="lineChart"></canvas></div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
          <div class="card-header">Job Types Distribution</div>
          <div class="card-body">
            <div class="chart-pie"><canvas id="pieChart"></canvas></div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center">
      <div class="dropdown">...</div>
      <div class="dropdown">...</div>
      <a href="#" class="btn btn-primary btn-sm me-2"><i class="fas fa-plus"></i> Add New Job</a>
      <a href="#" class="btn btn-info btn-sm me-2"><i class="fas fa-users"></i> Manage Candidates</a>
      <a href="#" class="btn btn-success btn-sm"><i class="fas fa-building"></i> View Employers</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      // Line Chart Example
      const ctxLine = document.getElementById('lineChart').getContext('2d');
      new Chart(ctxLine, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
          datasets: [{
            label: 'Applications',
            data: [10, 20, 15, 25, 30],
            borderColor: '#4e73df',
            fill: false
          }]
        }
      });
      // Pie Chart Example
      const ctxPie = document.getElementById('pieChart').getContext('2d');
      new Chart(ctxPie, {
        type: 'pie',
        data: {
          labels: ['Full-Time', 'Part-Time', 'Freelance'],
          datasets: [{
            data: [50, 30, 20],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc']
          }]
        }
      });
    </script>

    <!-- Rest of the dashboard content would follow similarly with static data -->
    <!-- Removed charts and dynamic sections for simplicity -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>