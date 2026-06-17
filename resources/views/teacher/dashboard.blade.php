@extends('layouts.app')
@section('title', 'Teacher Dashboard')
@section('page-title', 'My Dashboard')

@section('content')

@if(session('success'))
    <div class="alert-success-custom">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fas fa-book"></i></div>
            <div>
                <div class="stat-label">My Courses</div>
                <div class="stat-value">{{ $courses->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-label">Total Students</div>
                <div class="stat-value">{{ $courses->sum('enrollments_count') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fas fa-tasks"></i></div>
            <div>
                <div class="stat-label">Total Assignments</div>
                <div class="stat-value">{{ $courses->sum('assignments_count') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Courses list --}}
<div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 style="margin:0; border:none; padding:0;"><i class="fas fa-book-open"></i> My Courses</h5>
        <a href="{{ route('teacher.courses.create') }}" class="btn-primary-custom">
            <i class="fas fa-plus"></i> New Course
        </a>
    </div>

    @if($courses->isEmpty())
        <div style="text-align:center; padding:40px; color:#9ca3af;">
            <i class="fas fa-book" style="font-size:3rem; opacity:.3;"></i>
            <p style="margin-top:14px;">No courses yet. Create your first course!</p>
            <a href="{{ route('teacher.courses.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i> Create Course
            </a>
        </div>
    @else
        <div class="row g-3">
            @foreach($courses as $course)
            <div class="col-md-6">
                <div class="course-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6>{{ $course->title }}</h6>
                        <span class="course-tag">{{ $course->enrollments_count }} students</span>
                    </div>
                    <p>{{ Str::limit($course->description, 80) ?: 'No description.' }}</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('teacher.assignments.create', $course) }}"
                           class="btn-primary-custom" style="font-size:.8rem; padding:6px 14px;">
                            <i class="fas fa-plus"></i> Assignment
                        </a>
                        <a href="{{ route('teacher.assignments', $course) }}"
                           class="btn-outline-custom" style="font-size:.8rem; padding:6px 14px;">
                            <i class="fas fa-list"></i> Assignments ({{ $course->assignments_count }})
                        </a>
                        <a href="{{ route('teacher.lectures.create', $course) }}"
                           class="btn-success-custom" style="font-size:.8rem; padding:6px 14px;">
                            <i class="fas fa-upload"></i> Upload Lecture
                        </a>
                        <a href="{{ route('teacher.lectures', $course) }}"
                           class="btn-outline-custom" style="font-size:.8rem; padding:6px 14px;">
                            <i class="fas fa-video"></i> Lectures ({{ $course->lectures_count }})
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
