@extends('layouts.app')
@section('title', 'Assignment Submit')
@section('page-title', 'Assignment Submit Karein')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div style="background:#ede9fe; border-radius:10px; padding:12px 16px; margin-bottom:18px; font-size:.87rem; color:#5b21b6;">
            <i class="fas fa-file-alt"></i>
            Assignment: <strong>{{ $assignment->title }}</strong>
            <span style="float:right; color:{{ now()->gt($assignment->due_date) ? '#dc2626' : '#16a34a' }};">
                Due: {{ $assignment->due_date }}
            </span>
        </div>

        @if($errors->any())
            <div class="alert-error-custom">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <div class="card-box">
            <h5><i class="fas fa-upload"></i> File Upload Karein</h5>

            @if($assignment->description)
                <div style="background:#f8f7ff; border-radius:9px; padding:14px; margin-bottom:18px; font-size:.87rem; color:#4b5563;">
                    <strong>Instructions:</strong> {{ $assignment->description }}
                </div>
            @endif

            <form method="POST"
                  action="{{ route('student.submit', $assignment) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Assignment File <span style="color:red">*</span></label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx" required>
                    <div style="font-size:.78rem; color:#9ca3af; margin-top:5px;">
                        PDF, DOC, ya DOCX | Max 10MB
                    </div>
                </div>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-paper-plane"></i> Submit Karein
                </button>
                <a href="{{ route('student.dashboard') }}" class="btn-outline-custom ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
