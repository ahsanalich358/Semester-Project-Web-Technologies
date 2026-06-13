@extends('layouts.app')
@section('title', 'Upload Lecture')
@section('page-title', 'Upload Lecture')

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
            <h5><i class="fas fa-upload"></i> Lecture Details</h5>
            <form method="POST"
                  action="{{ route('teacher.lectures.store', $course) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Lecture Title <span style="color:red">*</span></label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title') }}" placeholder="e.g. Introduction to Algebra" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Brief description of this lecture...">{{ old('description') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label">Lecture File (PDF or Word) <span style="color:red">*</span></label>
                    <input type="file" name="lecture_file" class="form-control"
                           accept=".pdf,.doc,.docx" required>
                    <div style="font-size:.78rem; color:#9ca3af; margin-top:4px;">
                        Accepted: PDF, DOC, DOCX &nbsp;|&nbsp; Max size: 20MB
                    </div>
                </div>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Lecture
                </button>
                <a href="{{ route('teacher.lectures', $course) }}" class="btn-outline-custom ms-2">Cancel</a>
            </form>
        </div>

    </div>
</div>
@endsection
