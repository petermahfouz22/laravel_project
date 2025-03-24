<x-admin-layout title="Admin Dashboard">
  <div class="container-fluid px-4 mt-14">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-blue-500 hover:shadow-lg transition-shadow duration-300">
              <div class="p-4">
                  <div class="flex justify-between items-center">
                      <div>
                          <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Active Jobs</p>
                          <p class="text-2xl font-bold text-gray-800 mt-1">{{ $activeJobs ?? 25 }}</p>
                      </div>
                      <div class="p-3 bg-blue-100 rounded-full">
                          <i class="fas fa-briefcase text-blue-500 text-xl"></i>
                      </div>
                  </div>
              </div>
              <div class="bg-gray-50 px-4 py-2 border-t">
                  <a href="{{ route('admin.jobs.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex justify-end items-center">
                      View Details
                      <i class="fas fa-arrow-right ml-1 text-xs"></i>
                  </a>
              </div>
          </div>
          <!-- Repeat for other cards (Total Employers, Registered Candidates, Total Applications) -->
      </div>
      <!-- Charts Section -->
      <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
          <div class="lg:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
              <div class="flex items-center justify-between px-6 py-4 border-b">
                  <h2 class="text-lg font-semibold text-gray-800">Job Applications Over Time</h2>
                  <div class="flex space-x-2">
                      <button class="px-3 py-1 text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full">Week</button>
                      <button class="px-3 py-1 text-xs font-medium bg-indigo-100 text-indigo-700 rounded-full">Month</button>
                      <button class="px-3 py-1 text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full">Year</button>
                  </div>
              </div>
              <div class="p-6">
                  <div class="h-64">
                      <canvas id="lineChart"></canvas>
                  </div>
              </div>
          </div>
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <div class="flex items-center justify-between px-6 py-4 border-b">
                  <h2 class="text-lg font-semibold text-gray-800">Job Types Distribution</h2>
                  <button class="text-sm text-indigo-600 hover:text-indigo-800">
                      <i class="fas fa-download"></i>
                  </button>
              </div>
              <div class="p-6">
                  <div class="h-64">
                      <canvas id="pieChart"></canvas>
                  </div>
                  <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                      <div class="flex flex-col items-center">
                          <div class="w-3 h-3 rounded-full bg-indigo-500 mb-1"></div>
                          <span class="text-xs text-gray-600">Full-Time</span>
                          <span class="text-sm font-medium">50%</span>
                      </div>
                      <div class="flex flex-col items-center">
                          <div class="w-3 h-3 rounded-full bg-green-500 mb-1"></div>
                          <span class="text-xs text-gray-600">Part-Time</span>
                          <span class="text-sm font-medium">30%</span>
                      </div>
                      <div class="flex flex-col items-center">
                          <div class="w-3 h-3 rounded-full bg-blue-500 mb-1"></div>
                          <span class="text-xs text-gray-600">Freelance</span>
                          <span class="text-sm font-medium">20%</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  @push('scripts')
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
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
  @endpush
</x-admin-layout>