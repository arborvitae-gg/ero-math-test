<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div>
        <table>
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Grade') }}</th>
                    <th>{{ __('School') }}</th>
                    <th>{{ __('Coach') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->grade_level ?? '-' }}</td>
                        <td>{{ $user->school }}</td>
                        <td>{{ $user->coach_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
