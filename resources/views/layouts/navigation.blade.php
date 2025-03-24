<nav class="bg-gray-800 text-white p-4">
  <div class="max-w-7xl mx-auto flex justify-between">
      <div>
          <a href="{{ route('welcome') }}" class="text-lg font-bold">Job Portal</a>
      </div>
      <div class="space-x-4">
          @auth
              @switch(auth()->user()->role)
                  @case('candidate')
                      <a href="{{ route('candidate.dashboard') }}">Dashboard</a>
                      <a href="{{ route('candidate.profile.index') }}">Profile</a>
                      <a href="{{ route('candidate.jobs.index') }}">Jobs</a>
                      @break
                  @case('employer')
                      <a href="{{ route('employer.dashboard') }}">Dashboard</a>
                      <a href="{{ route('employer.companies.index') }}">Company Profile</a>
                      <a href="{{ route('employer.jobs.index') }}">Jobs</a>
                      @break
                  @case('admin')
                      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                      <a href="{{ route('admin.users.index') }}">Users</a>
                      <a href="{{ route('admin.jobs.index') }}">Jobs</a>
                      @break
              @endswitch
              <form method="POST" action="{{ route('logout') }}" class="inline">
                  @csrf
                  <button type="submit">Logout</button>
              </form>
          @else
              <a href="{{ route('login') }}">Login</a>
              <a href="{{ route('register') }}">Register</a>
          @endauth
      </div>
  </div>
</nav>