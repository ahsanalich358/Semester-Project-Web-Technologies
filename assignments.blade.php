@extends('layouts.app')
@section('title', 'Assignments')
@section('page-title', 'Course Assignments')

@section('content')

<div style="background:#ede9fe; border-radius:10px; padding:12px 16px; margin-bottom:18px; font-size:.87rem; color:#5b21b6;">
    <i class="fas fa-book"></i> Course: <strong>{{ $course->title }}</strong>
</div>

<div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 style="margin:0; border:none; padding:0;"><i class="fas fa-tasks"></i> Assignments ({{ $assignments->count() }})</h5>
        <a href="{{ route('teacher.assignments.create', $course) }}" class="btn-primary-custom">
            <i class="fas fa-plus"></i> New Assignment
        </a>
    </div>

    @if($assignments->isEmpty())
        <p style="color:#9ca3af; text-align:center; padding:30px;">No assignments available.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Due Date</th>
                        <th>Notes</th>
                        <th>Submissions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $i => $a)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $a->title }}</strong></td>
                        <td>
                            <span style="color:{{ now()->gt($a->due_date) ? '#dc2626' : '#16a34a' }}; font-size:.85rem;">
                                <i class="fas fa-calendar"></i> {{ $a->due_date }}
                            </span>
                        </td>
                        <td>
                            @if($a->notes_file)
                                <span style="color:#16a34a; font-size:.82rem;"><i class="fas fa-file-pdf"></i> PDF hai</span>
                            @else
                                <span style="color:#9ca3af; font-size:.82rem;">—</span>
                            @endif
                        </td>
                        <td>
                            <span style="background:#dbeafe; color:#2563eb; padding:2px 10px; border-radius:20px; font-size:.8rem; font-weight:700;">
                                {{ $a->submissions_count }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('teacher.submissions', $a) }}" class="btn-outline-custom" style="font-size:.78rem; padding:5px 12px;">
                                <i class="fas fa-eye"></i> Submissions
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
