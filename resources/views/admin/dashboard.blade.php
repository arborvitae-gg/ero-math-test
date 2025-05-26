@extends('layouts.app')

@section('content')
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <h2>Admin Dashboard</h2>
            <p>Welcome, {{ Auth::user()->first_name }}! Manage your quizzes and users here.</p>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3>Users</h3>
                <p>Manage registered users and their roles</p>
                <a href="{{ route('admin.users.index') }}" class="card-link">View Users</a>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fa-solid fa-clipboard-question"></i>
                </div>
                <h3>Quizzes</h3>
                <p>Create and manage quizzes and questions</p>
                <a href="{{ route('admin.quizzes.index') }}" class="card-link">Manage Quizzes</a>
            </div>
        </div>
    </div>

    <style>
        .admin-dashboard {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .dashboard-header h2 {
            font-size: 2.5rem;
            color: rgb(19, 15, 64);
            margin-bottom: 1rem;
        }

        .dashboard-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 32px rgba(0, 0, 139, 0.12);
        }

        .card-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1.5rem;
            background: rgb(19, 15, 64);
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-icon i {
            font-size: 24px;
            color: white;
        }

        .dashboard-card h3 {
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .dashboard-card p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .card-link {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: rgb(19, 15, 64);
            color: white;
            text-decoration: none;
            border-radius: 24px;
            transition: background 0.3s ease;
        }

        .card-link:hover {
            background: rgb(59, 54, 140);
        }
    </style>
@endsection
