<nav class="main-navbar">
    <div class="navbar-content">
        <a href="{{ url('/') }}" class="navbar-logo">
            <img src="{{ asset('images/Erovoutika Light Logo.png') }}" alt="Ero-Math Logo">
        </a>
        <div class="navbar-links">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fa-solid fa-gauge-high"></i>
                Dashboard
            </a>
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="fa-solid fa-users"></i>
                    Users
                </a>
                <a href="{{ route('admin.quizzes.index') }}" class="nav-link">
                    <i class="fa-solid fa-clipboard-question"></i>
                    Quizzes
                </a>
            @endif
            <a href="{{ route('profile.edit') }}" class="nav-link">
                <i class="fa-solid fa-circle-user"></i>
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-link logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
