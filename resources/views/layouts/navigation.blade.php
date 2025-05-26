<nav class="nav-header">
    <div class="nav-content">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('images/Erovoutika Light Logo.png') }}" alt="Ero-Math Logo">
        </a>
        <div class="nav-links">
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="nav-btn">
                        <i class="fa-solid fa-gauge-high"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="fa-solid fa-users"></i>
                        Users
                    </a>
                    <a href="{{ route('admin.quizzes.index') }}" class="nav-link">
                        <i class="fa-solid fa-clipboard-question"></i>
                        Quizzes
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="nav-btn">
                        <i class="fa-solid fa-gauge-high"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('user.quizzes.index') }}" class="nav-link">
                        <i class="fa-solid fa-clipboard-question"></i>
                        My Quizzes
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}" class="nav-btn">
                    <i class="fa-solid fa-circle-user"></i>
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-btn logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-btn">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Login
                </a>
                <a href="{{ route('register') }}" class="nav-btn">
                    <i class="fa-solid fa-user-plus"></i>
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>

@pushOnce('styles')
    @vite(['resources/css/navigation.css'])
@endPushOnce
