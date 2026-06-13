<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary:      #4f46e5;
            --primary-dark: #3730a3;
            --sidebar-bg:   #1e1b4b;
            --sidebar-text: #c7d2fe;
            --sidebar-hover:#312e81;
        }
        * { box-sizing: border-box; }
        body { background: #f0f2f9; font-family: 'Segoe UI', sans-serif; margin: 0; }

        /* ── Sidebar ── */
        .sidebar {
            width: 245px; min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed; top: 0; left: 0; z-index: 200;
            display: flex; flex-direction: column;
        }
        .sidebar-brand {
            padding: 20px 22px 16px;
            border-bottom: 1px solid #312e81;
            color: #fff; font-size: 1.1rem; font-weight: 700;
        }
        .sidebar-brand span { color: #818cf8; }
        .sidebar-role {
            font-size: 0.72rem; color: #818cf8;
            background: #312e81; padding: 2px 8px;
            border-radius: 10px; display: inline-block; margin-top: 4px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .sidebar nav { padding: 10px 0; flex: 1; }
        .sidebar nav a {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 22px; color: var(--sidebar-text);
            text-decoration: none; font-size: 0.9rem;
            transition: all 0.15s; border-left: 3px solid transparent;
        }
        .sidebar nav a:hover { background: var(--sidebar-hover); color: #fff; border-left-color: #818cf8; }
        .sidebar nav a.active { background: var(--sidebar-hover); color: #fff; border-left-color: var(--primary); }
        .sidebar nav a i { width: 18px; text-align: center; font-size: 0.9rem; }
        .sidebar-footer { padding: 14px 22px; border-top: 1px solid #312e81; }
        .sidebar-footer form button {
            background: transparent; border: 1px solid #4f46e5; color: #818cf8;
            padding: 7px 0; border-radius: 7px; font-size: 0.85rem;
            cursor: pointer; transition: all 0.15s; width: 100%;
        }
        .sidebar-footer form button:hover { background: #4f46e5; color: #fff; }

        /* ── Main ── */
        .main-content { margin-left: 245px; min-height: 100vh; }
        .topbar {
            background: #fff; padding: 14px 28px;
            border-bottom: 1px solid #e2e4f0;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar .page-title { font-size: 1.05rem; font-weight: 700; color: #1e1b4b; }
        .topbar .user-pill {
            background: #ede9fe; color: #5b21b6;
            padding: 5px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600;
        }
        .content-area { padding: 26px 28px; }

        /* ── Cards ── */
        .stat-card {
            background: #fff; border-radius: 14px;
            box-shadow: 0 2px 16px rgba(79,70,229,.07);
            padding: 22px 18px; display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 50px; height: 50px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; flex-shrink: 0;
        }
        .icon-purple { background:#ede9fe; color:#7c3aed; }
        .icon-blue   { background:#dbeafe; color:#2563eb; }
        .icon-green  { background:#dcfce7; color:#16a34a; }
        .icon-orange { background:#ffedd5; color:#ea580c; }
        .stat-label  { font-size: 0.78rem; color: #9ca3af; margin-bottom: 1px; }
        .stat-value  { font-size: 1.65rem; font-weight: 800; color: #1e1b4b; line-height: 1; }

        .card-box {
            background: #fff; border-radius: 14px;
            box-shadow: 0 2px 16px rgba(79,70,229,.07);
            padding: 22px; margin-bottom: 22px;
        }
        .card-box h5 {
            font-weight: 700; color: #1e1b4b; font-size: 0.97rem;
            border-bottom: 2px solid #ede9fe; padding-bottom: 10px; margin-bottom: 16px;
        }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: var(--primary); color: #fff; border: none;
            padding: 9px 22px; border-radius: 8px; font-size: 0.88rem;
            font-weight: 600; text-decoration: none; display: inline-flex;
            align-items: center; gap: 7px; transition: background .15s; cursor: pointer;
        }
        .btn-primary-custom:hover { background: var(--primary-dark); color: #fff; }
        .btn-outline-custom {
            background: transparent; border: 1.5px solid var(--primary);
            color: var(--primary); padding: 7px 18px; border-radius: 8px;
            font-size: 0.85rem; font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px; transition: all .15s;
        }
        .btn-outline-custom:hover { background: var(--primary); color: #fff; }
        .btn-success-custom {
            background: #16a34a; color: #fff; border: none;
            padding: 7px 18px; border-radius: 8px; font-size: 0.85rem;
            font-weight: 600; cursor: pointer; transition: background .15s;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-success-custom:hover { background: #15803d; color: #fff; }
        .btn-danger-sm {
            background: #fee2e2; color: #dc2626; border: none;
            padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; cursor: pointer;
        }
        .btn-danger-sm:hover { background: #dc2626; color: #fff; }

        /* ── Table ── */
        .table th {
            background: #f8f7ff; color: #6b7280;
            font-size: 0.77rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .5px; border-top: none;
        }
        .table td { vertical-align: middle; font-size: 0.88rem; }

        /* ── Badges ── */
        .badge-role { padding: 3px 12px; border-radius: 20px; font-size: 0.73rem; font-weight: 700; }
        .badge-admin   { background:#fef3c7; color:#d97706; }
        .badge-teacher { background:#dbeafe; color:#2563eb; }
        .badge-student { background:#dcfce7; color:#16a34a; }

        /* ── Alerts ── */
        .alert-success-custom {
            background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
            padding: 11px 16px; border-radius: 9px; font-size: 0.88rem;
            display: flex; align-items: center; gap: 8px; margin-bottom: 16px;
        }
        .alert-error-custom {
            background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;
            padding: 11px 16px; border-radius: 9px; font-size: 0.88rem;
            display: flex; align-items: center; gap: 8px; margin-bottom: 16px;
        }

        /* ── Form ── */
        .form-label { font-weight: 600; font-size: 0.85rem; color: #374151; margin-bottom: 5px; }
        .form-control, .form-select {
            border: 1.5px solid #e5e7eb; border-radius: 8px;
            padding: 9px 13px; font-size: 0.9rem; transition: border .15s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,.12); outline: none;
        }

        /* ── Course cards ── */
        .course-card {
            background: #fff; border-radius: 12px;
            box-shadow: 0 2px 12px rgba(79,70,229,.07);
            padding: 18px; transition: transform .15s, box-shadow .15s; height: 100%;
        }
        .course-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79,70,229,.12); }
        .course-card h6 { font-weight: 700; color: #1e1b4b; margin-bottom: 6px; }
        .course-card p  { font-size: 0.83rem; color: #6b7280; margin-bottom: 12px; }
        .course-tag {
            background: #ede9fe; color: #5b21b6;
            padding: 2px 10px; border-radius: 20px; font-size: 0.74rem; font-weight: 600;
        }

        /* ── AI Page ── */
        .ai-box {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
            border-radius: 16px; padding: 28px; color: #fff; margin-bottom: 22px;
        }
        .ai-box h4 { font-weight: 800; margin-bottom: 6px; }
        .ai-box p  { color: #c7d2fe; font-size: 0.9rem; margin: 0; }
        .ai-answer-box {
            background: #f8f7ff; border: 1.5px solid #ede9fe;
            border-radius: 12px; padding: 20px; white-space: pre-wrap;
            font-size: 0.9rem; line-height: 1.7; color: #1e1b4b;
        }

        /* ── Marks ── */
        .marks-pill { padding: 4px 14px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; }
        .marks-high { background: #dcfce7; color: #16a34a; }
        .marks-mid  { background: #fef9c3; color: #ca8a04; }
        .marks-low  { background: #fee2e2; color: #dc2626; }
        .marks-none { background: #f3f4f6; color: #9ca3af; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <div><i class="fas fa-graduation-cap"></i> StudyPortal</div>
        <div class="sidebar-role">{{ ucfirst(auth()->user()->role) }}</div>
    </div>

    <nav>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.users.create') }}" class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i> Create User
            </a>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fas fa-users"></i> All Users
            </a>
            <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings (AI Key)
            </a>

        @elseif(auth()->user()->role === 'teacher')
            <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('teacher.courses.create') }}" class="{{ request()->routeIs('teacher.courses.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i> Create Course
            </a>

        @elseif(auth()->user()->role === 'student')
            <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('student.marks') }}" class="{{ request()->routeIs('student.marks') ? 'active' : '' }}">
                <i class="fas fa-star"></i> My Marks
            </a>
            <a href="{{ route('student.ai') }}" class="{{ request()->routeIs('student.ai*') ? 'active' : '' }}">
                <i class="fas fa-robot"></i> AI Assistant
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div style="color:#818cf8; font-size:0.8rem; margin-bottom:8px;">
            <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="page-title">@yield('page-title', 'Dashboard')</div>
        <div class="user-pill"><i class="fas fa-user"></i> {{ auth()->user()->name }}</div>
    </div>
    <div class="content-area">
        @yield('content')
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
