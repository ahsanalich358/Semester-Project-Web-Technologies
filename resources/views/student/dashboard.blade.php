@extends('layouts.app')
@section('title', 'Student Dashboard')
@section('page-title', 'My Dashboard')

@section('content')

@if(session('success'))
    <div class="alert-success-custom">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- Enrolled Courses --}}
<div class="card-box">
    <h5><i class="fas fa-book-open" style="color:#4f46e5;"></i> My Enrolled Courses</h5>

    @if($enrolledCourses->isEmpty())
        <p style="color:#9ca3af; text-align:center; padding:20px;">
            You haven't enrolled in any courses yet.
        </p>
    @else
        <div class="row g-3">
            @foreach($enrolledCourses as $course)
            <div class="col-md-6">
                <div class="course-card">
                    <h6>{{ $course->title }}</h6>
                    <p>{{ Str::limit($course->description, 80) ?: 'No description.' }}</p>
                    <div style="font-size:.8rem; color:#9ca3af; margin-bottom:10px;">
                        <i class="fas fa-chalkboard-teacher"></i> {{ $course->teacher->name }}
                    </div>
                    <a href="{{ route('student.course.detail', $course) }}" class="btn-primary-custom" style="font-size:.8rem; padding:6px 14px;">
                        <i class="fas fa-eye"></i> View Course
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Available Courses --}}
<div class="card-box">
    <h5><i class="fas fa-search" style="color:#16a34a;"></i> Available Courses</h5>

    @if($availableCourses->isEmpty())
        <p style="color:#9ca3af; text-align:center; padding:20px;">
            No more courses available to enroll.
        </p>
    @else
        <div class="row g-3">
            @foreach($availableCourses as $course)
            <div class="col-md-6">
                <div class="course-card">
                    <h6>{{ $course->title }}</h6>
                    <p>{{ Str::limit($course->description, 80) ?: 'No description.' }}</p>
                    <div style="font-size:.8rem; color:#9ca3af; margin-bottom:10px;">
                        <i class="fas fa-chalkboard-teacher"></i> {{ $course->teacher->name }}
                    </div>
                    <form method="POST" action="{{ route('student.enroll', $course) }}">
                        @csrf
                        <button type="submit" class="btn-success-custom" style="font-size:.8rem; padding:6px 14px;">
                            <i class="fas fa-plus"></i> Enroll
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
