<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalCourses  = Course::count();
        $recentUsers   = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalStudents', 'totalTeachers', 'totalCourses', 'recentUsers'));
    }

    public function createUser()
    {
        return view('admin.create_user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:teacher,student',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return back()->with('success', 'User created successfully!');
    }

    public function users()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    public function settings()
    {
        // Fix: always ensure a settings row exists
        $setting = Setting::firstOrCreate([], ['gemini_api_key' => null]);
        return view('admin.settings', compact('setting'));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'gemini_api_key' => 'nullable|string',
        ]);

        // Fix: always update — never fails even if row was just created
        $setting = Setting::firstOrCreate([], ['gemini_api_key' => null]);
        $setting->update(['gemini_api_key' => $request->gemini_api_key]);

        return back()->with('success', 'Settings saved successfully!');
    }
}
