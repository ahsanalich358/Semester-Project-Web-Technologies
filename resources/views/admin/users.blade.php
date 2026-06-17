@extends('layouts.app')
@section('title', 'All Users')
@section('page-title', 'All Users')

@section('content')

@if(session('success'))
    <div class="alert-success-custom">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 style="margin:0; border:none; padding:0;"><i class="fas fa-users"></i> Users ({{ $users->count() }})</h5>
        <a href="{{ route('admin.users.create') }}" class="btn-primary-custom">
            <i class="fas fa-plus"></i> New User
        </a>
    </div>

    @if($users->isEmpty())
        <p style="color:#9ca3af; text-align:center; padding:30px 0;">
            <i class="fas fa-users" style="font-size:2rem; opacity:.3;"></i><br>
            No User Avaialable.
        </p>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Naam</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $u)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $u->name }}</strong></td>
                        <td>{{ $u->email }}</td>
                        <td><span class="badge-role badge-{{ $u->role }}">{{ ucfirst($u->role) }}</span></td>
                        <td style="color:#9ca3af; font-size:.8rem;">{{ $u->created_at->format('d M Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.delete', $u) }}"
                                  onsubmit="return confirm('delete User ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger-sm">
                                    <i class="fas fa-trash"></i> Delete
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
@endsection
