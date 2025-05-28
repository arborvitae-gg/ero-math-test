<nav class="main-navbar">
    <div class="navbar-content">
        <div class="navbar-links">
            @auth
                {{-- if authenticated and on welcome route --}}
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>

                @if (!request()->is('/'))
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="nav-link">Users</a>
                        <a href="{{ route('admin.quizzes.index') }}" class="nav-link">Quizzes</a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="nav-link">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link">Logout</button>
                    </form>
                @endif

                {{-- If on guest mode --}}
            @else
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-link primary">Register</a>
            @endauth
        </div>
    </div>
</nav>
