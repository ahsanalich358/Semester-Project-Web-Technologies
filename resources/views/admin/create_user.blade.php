@extends('layouts.app')
@section('title', 'Create User')
@section('page-title', 'Create New User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error-custom">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <div class="card-box">
            <h5><i class="fas fa-user-plus"></i> Create Teacher or Student ID </h5>

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" placeholder="Enter fullname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email <span style="color:red">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" placeholder="email@domain.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password <span style="color:red">*</span></label>
                    <input type="password" name="password" class="form-control"
                           placeholder="minimum 6 letters" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Role <span style="color:red">*</span></label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Select Role --</option>
                        <option value="teacher" {{ old('role')=='teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="student" {{ old('role')=='student' ? 'selected' : '' }}>Student</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-save"></i> Create User
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn-outline-custom ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
