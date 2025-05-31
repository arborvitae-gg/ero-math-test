<x-app-layout>

    <x-slot name="header">
        <h2 class="dashboard-title">
            {{ __('Registered Users') }}
        </h2>
    </x-slot>

    <div>
        <table class="admin-table" id="users-table">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">First Name</th>
                    <th onclick="sortTable(1)">Last Name</th>
                    <th onclick="sortTable(2)">Email</th>
                    <th onclick="sortTable(3)">Grade</th>
                    <th onclick="sortTable(4)">Category</th>
                    <th onclick="sortTable(5)">School</th>
                    <th onclick="sortTable(6)">Coach</th>
                    <th></th> {{-- Actions column --}}
                </tr>
            </thead>
            <tbody>
                {{-- foreach loops through all the users in the database --}}
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->grade_level ?? '-' }}</td>
                        <td>{{ \App\Models\Category::findCategoryForGrade($user->grade_level)?->name ?? '-' }}</td>
                        <td>{{ $user->school }}</td>
                        <td>{{ $user->coach_name }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                onsubmit="return confirm('Are you sure you want to delete this user (Quiz scores/data included)? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-action-btn danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
