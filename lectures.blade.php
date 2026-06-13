@extends('layouts.app')
@section('title', 'Lectures')
@section('page-title', 'Course Lectures')

@section('content')

@if(session('success'))
    <div class="alert-success-custom">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div style="background:#ede9fe; border-radius:10px; padding:12px 16px; margin-bottom:18px; font-size:.87rem; color:#5b21b6;">
    <i class="fas fa-book"></i>
    Course: <strong>{{ $course->title }}</strong>
</div>

<div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 style="margin:0; border:none; padding:0;">
            <i class="fas fa-video"></i> Lectures ({{ $lectures->count() }})
        </h5>
        <a href="{{ route('teacher.lectures.create', $course) }}" class="btn-primary-custom">
            <i class="fas fa-plus"></i> Upload New Lecture
        </a>
    </div>

    @if($lectures->isEmpty())
        <div style="text-align:center; padding:40px; color:#9ca3af;">
            <i class="fas fa-file-upload" style="font-size:3rem; opacity:.3;"></i>
            <p style="margin-top:14px;">No lectures uploaded yet.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Uploaded</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lectures as $i => $lecture)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $lecture->title }}</strong>
                            @if($lecture->description)
                                <br><span style="font-size:.78rem; color:#9ca3af;">{{ Str::limit($lecture->description, 60) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($lecture->file_type === 'pdf')
                                <span style="background:#fee2e2; color:#dc2626; padding:3px 10px; border-radius:20px; font-size:.75rem; font-weight:700;">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </span>
                            @else
                                <span style="background:#dbeafe; color:#2563eb; padding:3px 10px; border-radius:20px; font-size:.75rem; font-weight:700;">
                                    <i class="fas fa-file-word"></i> Word
                                </span>
                            @endif
                        </td>
                        <td style="font-size:.82rem; color:#6b7280;">
                            {{ $lecture->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ asset('storage/' . $lecture->file) }}"
                                   target="_blank"
                                   class="btn-outline-custom" style="font-size:.78rem; padding:4px 12px;">
                                    <i class="fas fa-eye"></i> Preview
                                </a>
                                <form method="POST" action="{{ route('teacher.lectures.delete', $lecture) }}"
                                      onsubmit="return confirm('Delete this lecture?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<a href="{{ route('teacher.dashboard') }}" class="btn-outline-custom">
    <i class="fas fa-arrow-left"></i> Back to Dashboard
</a>
@endsection
