@extends('layouts.app')
@section('title', 'Create Course')
@section('page-title', 'Create New Course')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        @if($errors->any())
            <div class="alert-error-custom">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <div class="card-box">
            <h5><i class="fas fa-book-medical"></i>Enter Course Details</h5>
            <form method="POST" action="{{ route('teacher.courses.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Course Title <span style="color:red">*</span></label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title') }}" placeholder="Jaise: Physics Class 10" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Course Description</label>
                    <textarea name="description" class="form-control" rows="4"
                              placeholder="Course ke baare mein thodi si information...">{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-save"></i> Create Course
                </button>
                <a href="{{ route('teacher.dashboard') }}" class="btn-outline-custom ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
