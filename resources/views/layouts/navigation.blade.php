<nav x-data="{ open: false }">
    {{-- Primary Navigation Menu --}}
    <div>
        <div>
            <div>
                {{-- Logo --}}
                <div>
                    <a href="{{ route('dashboard') }}">
                        Logo
                        {{-- <x-application-logo /> --}}
                    </a>
                </div>

                {{-- Navigation Links --}}
                <div>
                    {{-- active="request()->routeIs('dashboard') --}}
                    <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>

                    {{-- Admin Navigation Links --}}
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
                        <a href="{{ route('admin.quizzes.index') }}">{{ __('Quizzes') }}</a>
                    @endif

                    {{-- User Navigation Links --}}

                </div>
            </div>

            {{-- Profile edit and logout --}}
            <div>
                <p>{{ Auth::user()->first_name }}</p>

                <a href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">{{ __('Log Out') }}</button>
                </form>

            </div>
        </div>
    </div>

</nav>
