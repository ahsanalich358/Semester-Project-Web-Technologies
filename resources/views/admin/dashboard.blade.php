@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')

@if(session('success'))
    <div class="alert-success-custom">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fas fa-user-graduate"></i></div>
            <div>
                <div class="stat-label">Total Students</div>
                <div class="stat-value">{{ $totalStudents }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <div class="stat-label">Total Teachers</div>
                <div class="stat-value">{{ $totalTeachers }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fas fa-book"></i></div>
            <div>
                <div class="stat-label">Total Courses</div>
                <div class="stat-value">{{ $totalCourses }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 style="margin:0; border:none; padding:0;"><i class="fas fa-users"></i> Recent Users</h5>
        <a href="{{ route('admin.users.create') }}" class="btn-primary-custom">
            <i class="fas fa-plus"></i> New User
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentUsers as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge-role badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                    <td style="color:#9ca3af; font-size:.8rem;">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
