@extends('layouts.app')
@section('title', $course->title)
@section('page-title', $course->title)

@section('content')

@if(session('success'))
    <div class="alert-success-custom"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

<div style="background: linear-gradient(135deg,#4f46e5,#7c3aed); border-radius:14px; padding:22px 24px; color:#fff; margin-bottom:22px;">
    <h4 style="font-weight:800; margin-bottom:5px;">{{ $course->title }}</h4>
    <p style="color:#c7d2fe; margin:0; font-size:.9rem;">
        <i class="fas fa-chalkboard-teacher"></i> Teacher: {{ $course->teacher->name }}
        &nbsp;|&nbsp;
        <i class="fas fa-tasks"></i> {{ $assignments->count() }} Assignments
        &nbsp;|&nbsp;
        <i class="fas fa-video"></i> {{ $lectures->count() }} Lectures
    </p>
    @if($course->description)
        <p style="margin-top:10px; color:#e0e7ff; font-size:.88rem;">{{ $course->description }}</p>
    @endif
</div>

{{-- ── Lectures Section ── --}}
<div class="card-box">
    <h5><i class="fas fa-video" style="color:#4f46e5;"></i> Lecture Materials</h5>

    @if($lectures->isEmpty())
        <p style="color:#9ca3af; text-align:center; padding:20px;">
            <i class="fas fa-file-upload" style="font-size:2rem; opacity:.3;"></i><br>
            No lectures uploaded yet.
        </p>
    @else
        <div class="row g-3">
            @foreach($lectures as $lecture)
            <div class="col-md-6">
                <div style="border:1px solid #e5e7eb; border-radius:11px; padding:16px;">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:42px; height:42px; border-radius:10px; flex-shrink:0;
                                    background:{{ $lecture->file_type === 'pdf' ? '#fee2e2' : '#dbeafe' }};
                                    display:flex; align-items:center; justify-content:center;
                                    color:{{ $lecture->file_type === 'pdf' ? '#dc2626' : '#2563eb' }}; font-size:1.2rem;">
                            <i class="fas fa-file-{{ $lecture->file_type === 'pdf' ? 'pdf' : 'word' }}"></i>
                        </div>
                        <div style="flex:1;">
                            <div style="font-weight:700; color:#1e1b4b; font-size:.9rem;">{{ $lecture->title }}</div>
                            @if($lecture->description)
                                <div style="font-size:.78rem; color:#6b7280; margin-top:3px;">{{ $lecture->description }}</div>
                            @endif
                            <div style="font-size:.75rem; color:#9ca3af; margin-top:4px;">
                                {{ strtoupper($lecture->file_type) }} &nbsp;·&nbsp; {{ $lecture->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('student.lecture.download', $lecture) }}"
                           class="btn-primary-custom" style="font-size:.8rem; padding:6px 16px;">
                            <i class="fas fa-download"></i> Download Lecture
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ── Assignments Section ── --}}
<div class="card-box">
    <h5><i class="fas fa-file-alt"></i> Assignments</h5>

    @if($assignments->isEmpty())
        <p style="color:#9ca3af; text-align:center; padding:30px;">
            <i class="fas fa-inbox" style="font-size:2.5rem; opacity:.3;"></i><br>
            No assignments posted yet.
        </p>
    @else
        @foreach($assignments as $assignment)
        <div style="border:1px solid #e5e7eb; border-radius:11px; padding:18px; margin-bottom:14px;">
            <div class="d-flex justify-content-between align-items-start">
                <div style="flex:1;">
                    <h6 style="font-weight:700; color:#1e1b4b; margin-bottom:5px;">{{ $assignment->title }}</h6>
                    @if($assignment->description)
                        <p style="color:#6b7280; font-size:.85rem; margin-bottom:8px;">{{ $assignment->description }}</p>
                    @endif
                    <div style="font-size:.8rem; color:#9ca3af;">
                        <i class="fas fa-calendar-alt"></i> Due: {{ $assignment->due_date }}
                        @if(now()->gt($assignment->due_date))
                            <span style="color:#dc2626; font-weight:600;"> (Expired)</span>
                        @endif
                    </div>
                </div>
                <div style="margin-left:16px;">
                    @if(in_array($assignment->id, $submittedIds))
                        <span style="background:#dcfce7; color:#16a34a; padding:4px 12px; border-radius:20px; font-size:.78rem; font-weight:700;">
                            <i class="fas fa-check"></i> Submitted
                        </span>
                    @else
                        <span style="background:#fef3c7; color:#d97706; padding:4px 12px; border-radius:20px; font-size:.78rem; font-weight:700;">
                            Pending
                        </span>
                    @endif
                </div>
            </div>

            <div class="d-flex gap-2 mt-3 flex-wrap">
                @if($assignment->notes_file)
                    <a href="{{ asset('storage/' . $assignment->notes_file) }}"
                       download
                       class="btn-outline-custom" style="font-size:.8rem; padding:6px 14px;">
                        <i class="fas fa-file-download"></i> Download Notes
                    </a>
                @endif
                @if(!in_array($assignment->id, $submittedIds))
                    <a href="{{ route('student.submit.form', $assignment) }}"
                       class="btn-primary-custom" style="font-size:.8rem; padding:6px 14px;">
                        <i class="fas fa-upload"></i> Submit Assignment
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    @endif
</div>

<a href="{{ route('student.dashboard') }}" class="btn-outline-custom">
    <i class="fas fa-arrow-left"></i> Back to Dashboard
</a>
@endsection
