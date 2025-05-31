<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/Erovoutika Light Logo.png') }}" alt="Erovoutika Logo">
            </a>
        </div>

        <button class="navbar-toggle" id="navbar-toggle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 12H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M3 6H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>

        <div class="navbar-menu" id="navbar-menu">
            @guest
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
                @endif
            @else
                @if (Auth::user()->role === 'user')
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">Profile</a>
                @elseif (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.quizzes.index') }}" class="{{ request()->routeIs('admin.quizzes.*') ? 'active' : '' }}">Quizzes</a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">Profile</a>
                    <!-- Add more admin links as needed -->
                @endif
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </a>
                </form>
            @endguest
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbarToggle = document.getElementById('navbar-toggle');
    const navbarMenu = document.getElementById('navbar-menu');

    navbarToggle.addEventListener('click', function() {
        navbarMenu.classList.toggle('active');
    });
});
</script> 