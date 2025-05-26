@extends('layouts.app')

@section('content')
    <div class="users-container">
        <div class="users-header">
            <h2>User Management</h2>
            <p>View and manage all registered users</p>
        </div>

        <div class="users-table-container">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge {{ $user->role }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->category->name ?? 'N/A' }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.users.show', $user) }}" class="action-btn view">
                                    <i class="fa-solid fa-eye"></i>
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .users-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .users-header {
            margin-bottom: 2rem;
        }

        .users-header h2 {
            font-size: 2rem;
            color: rgb(19, 15, 64);
            margin-bottom: 0.5rem;
        }

        .users-header p {
            color: #666;
        }

        .users-table-container {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
            overflow-x: auto;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
        }

        .users-table th {
            text-align: left;
            padding: 1rem;
            border-bottom: 2px solid #eee;
            color: rgb(19, 15, 64);
            font-weight: 600;
        }

        .users-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            color: #444;
        }

        .role-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .role-badge.admin {
            background: rgb(220, 252, 231);
            color: rgb(22, 101, 52);
        }

        .role-badge.user {
            background: rgb(224, 231, 255);
            color: rgb(40, 70, 199);
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.875rem;
            transition: background 0.3s ease;
        }

        .action-btn.view {
            background: rgb(224, 231, 255);
            color: rgb(40, 70, 199);
        }

        .action-btn.view:hover {
            background: rgb(199, 210, 254);
        }

        .action-btn i {
            font-size: 0.875rem;
        }
    </style>
@endsection
