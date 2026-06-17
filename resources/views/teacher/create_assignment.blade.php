@extends('layouts.app')
@section('title', 'Create Assignment')
@section('page-title', 'New Assignment')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div style="background:#ede9fe; border-radius:10px; padding:12px 16px; margin-bottom:18px; font-size:.87rem; color:#5b21b6;">
            <i class="fas fa-book"></i>
            Course: <strong>{{ $course->title }}</strong>
        </div>

        @if($errors->any())
            <div class="alert-error-custom">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <div class="card-box">
            <h5><i class="fas fa-file-alt"></i> Assignment Details</h5>
            <form method="POST"
                  action="{{ route('teacher.assignments.store', $course) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Assignment Title <span style="color:red">*</span></label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title') }}" placeholder="e.g. Chapter 3 Exercise" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description / Instructions</label>
                    <textarea name="description" class="form-control" rows="4"
                              placeholder="Write assignment instructions here...">{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Reference Notes (PDF or Word) — Optional</label>
                    <input type="file" name="notes_file" class="form-control" accept=".pdf,.doc,.docx">
                    <div style="font-size:.78rem; color:#9ca3af; margin-top:4px;">
                        PDF, DOC, DOCX — Max 10MB. Students can download this file.
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Due Date <span style="color:red">*</span></label>
                    <input type="date" name="due_date" class="form-control"
                           value="{{ old('due_date') }}" required>
                </div>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-save"></i> Create Assignment
                </button>
                <a href="{{ route('teacher.dashboard') }}" class="btn-outline-custom ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
