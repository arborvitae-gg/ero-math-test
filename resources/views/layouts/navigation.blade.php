<nav x-data="{ open: false }" class="nav-container">
    <!-- Navigation Links -->
        {{-- active="request()->routeIs('dashboard') --}}
        <img src="{{ asset('images/Erovoutika Light Logo.png') }}" alt="Logo">
        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
            <a href="{{ route('admin.quizzes.index') }}">{{ __('Quizzes') }}</a>
        @endif

    <p>{{ Auth::user()->name }}</p>
    <a href="{{ route('profile.edit') }}"><i class="fa-solid fa-circle-user"></i></a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"><i class="fa-solid fa-right-from-bracket"></i>
        </button>
    </form>
</nav>
