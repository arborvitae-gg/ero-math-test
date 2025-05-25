<nav class="main-navbar">
    <div class="navbar-content">
        <a href="{{ url('/') }}" class="navbar-logo">
            <img src="{{ asset('images/Erovoutika Light Logo.png') }}" alt="Ero-Math Logo">
        </a>
        <div class="navbar-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.users.index') }}">Users</a>
                <a href="{{ route('admin.quizzes.index') }}">Quizzes</a>
            @endif
            <a href="{{ route('profile.edit') }}"><i class="fa-solid fa-circle-user"></i> Profile</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
            </form>
        </div>
    </div>
</nav>

<style>
.main-navbar {
    background: rgba(0, 0, 139, 0.92);
    padding: 0.5rem 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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
    gap: 1.2rem;
}
.navbar-links a,
.navbar-links button.logout-btn {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    padding: 0.5rem 1.1rem;
    border-radius: 4px;
    background: none;
    border: none;
    transition: background 0.2s;
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.navbar-links a:hover,
.navbar-links button.logout-btn:hover {
    background: #1a2533;
}
@media (max-width: 700px) {
    .navbar-content {
        flex-direction: column;
        align-items: flex-start;
        padding: 0 1rem;
    }
    .navbar-links {
        flex-direction: column;
        width: 100%;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
}
</style>
