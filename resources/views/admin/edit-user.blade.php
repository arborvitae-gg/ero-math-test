<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Edit User') }}</h2>
    </x-slot>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PATCH')

        <!-- First Name -->
        <div>
            <label for="first_name">{{ __('First Name') }}</label>
            <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}"
                required />
            <x-input-error :messages="$errors->get('first_name')" />
        </div>

        <!-- Middle Name -->
        <div>
            <label for="middle_name">{{ __('Middle Name') }}</label>
            <input id="middle_name" name="middle_name" type="text"
                value="{{ old('middle_name', $user->middle_name) }}" />
            <x-input-error :messages="$errors->get('middle_name')" />
        </div>

        <!-- Last Name -->
        <div>
            <label for="last_name">{{ __('Last Name') }}</label>
            <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}"
                required />
            <x-input-error :messages="$errors->get('last_name')" />
        </div>

        <!-- Email -->
        <div>
            <label for="email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Grade Level -->
        <div>
            <label for="grade_level">{{ __('Grade Level') }}</label>
            <input id="grade_level" name="grade_level" type="number" min="1" max="12"
                value="{{ old('grade_level', $user->grade_level) }}" />
            <x-input-error :messages="$errors->get('grade_level')" />
        </div>

        <!-- School -->
        <div>
            <label for="school">{{ __('School') }}</label>
            <input id="school" name="school" type="text" value="{{ old('school', $user->school) }}" />
            <x-input-error :messages="$errors->get('school')" />
        </div>

        <!-- Coach Name -->
        <div>
            <label for="coach_name">{{ __('Coach Name') }}</label>
            <input id="coach_name" name="coach_name" type="text"
                value="{{ old('coach_name', $user->coach_name) }}" />
            <x-input-error :messages="$errors->get('coach_name')" />
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.users.index') }}">{{ __('Cancel') }}</a>
            <button type="submit">{{ __('Save Changes') }}</button>
        </div>
    </form>
</x-app-layout>
