@extends('layouts.app')
@section('title', 'Submissions')
@section('page-title', 'Student Submissions')

@section('content')

@if(session('success'))
    <div class="alert-success-custom">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div style="background:#ede9fe; border-radius:10px; padding:12px 16px; margin-bottom:18px; font-size:.87rem; color:#5b21b6;">
    <i class="fas fa-file-alt"></i>
    Assignment: <strong>{{ $assignment->title }}</strong> &nbsp;|&nbsp;
    <i class="fas fa-calendar"></i> Due: {{ $assignment->due_date }}
</div>

<div class="card-box">
    <h5><i class="fas fa-list-check"></i> Submissions ({{ $submissions->count() }})</h5>

    @if($submissions->isEmpty())
        <p style="color:#9ca3af; text-align:center; padding:30px;">
            <i class="fas fa-inbox" style="font-size:2.5rem; opacity:.3;"></i><br>
            No submissions received yet.
        </p>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Download File</th>
                        <th>Submitted At</th>
                        <th>Marks</th>
                        <th>Assign Marks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $i => $sub)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $sub->student->name }}</strong><br>
                            <span style="font-size:.78rem; color:#9ca3af;">{{ $sub->student->email }}</span>
                        </td>
                        <td>
                            <a href="{{ route('teacher.submission.download', $sub) }}"
                               class="btn-primary-custom" style="font-size:.78rem; padding:4px 12px;">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </td>
                        <td style="font-size:.82rem; color:#6b7280;">
                            {{ $sub->created_at->format('d M Y, h:i A') }}
                        </td>
                        <td>
                            @if($sub->marks !== null)
                                <span class="marks-pill {{ $sub->marks >= 70 ? 'marks-high' : ($sub->marks >= 40 ? 'marks-mid' : 'marks-low') }}">
                                    {{ $sub->marks }}/100
                                </span>
                            @else
                                <span class="marks-pill marks-none">—</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('teacher.marks', $sub) }}"
                                  class="d-flex gap-1 align-items-center">
                                @csrf
                                <input type="number" name="marks" min="0" max="100"
                                       value="{{ $sub->marks }}"
                                       class="form-control" style="width:70px; padding:5px 8px; font-size:.85rem;">
                                <button type="submit" class="btn-success-custom" style="padding:5px 12px; font-size:.82rem;">
                                    <i class="fas fa-check"></i> Save
                                </button>
                            </form>
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
