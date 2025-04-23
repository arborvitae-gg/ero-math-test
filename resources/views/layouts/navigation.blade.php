<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div>
        <div>
            <div>
                <!-- Logo -->
                <div>
                    <a href="{{ route('dashboard') }}">
                        Logo
                        {{-- <x-application-logo /> --}}
                    </a>
                </div>

                <!-- Navigation Links -->
                <div>
                    {{-- active="request()->routeIs('dashboard') --}}
                    <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>

                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
                        <a href="{{ route('admin.questions.index') }}">{{ __('Questions') }}</a>
                    @endif
                </div>
            </div>

            <!-- Settings -->
            <div>
                <p>{{ Auth::user()->name }}</p>

                <a href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">{{ __('Log Out') }}</button>
                </form>

            </div>
        </div>
    </div>

</nav>
