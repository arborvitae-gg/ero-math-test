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

<style>
.main-navbar {
    background: rgba(0, 0, 139, 0.92);
    padding: 0.75rem 0;
    box-shadow: 0 4px 24px rgba(0, 0, 139, 0.15);
    position: relative;
    z-index: 10;
}

.navbar-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.navbar-logo img {
    height: 40px;
    width: auto;
    display: block;
}

.navbar-links {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav-link,
.logout-btn {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
    border-radius: 8px;
    background: none;
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.nav-link:hover,
.logout-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-1px);
}

.nav-link.active {
    background: rgba(255, 255, 255, 0.1);
}

.logout-btn {
    color: #fecaca;
}

.logout-btn:hover {
    background: rgba(254, 202, 202, 0.1);
}

@media (max-width: 768px) {
    .navbar-content {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
    }

    .navbar-links {
        flex-direction: column;
        width: 100%;
        gap: 0.75rem;
    }

    .nav-link,
    .logout-btn {
        width: 100%;
        justify-content: center;
    }

    form {
        width: 100%;
    }
}
</style>
