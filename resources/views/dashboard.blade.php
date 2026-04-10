@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Welcome Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                    <p class="text-white text-opacity-90">{{ auth()->user()->role->name }} Dashboard</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if(auth()->user()->isAdmin())
        <!-- Admin Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Students</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['total_students'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Courses</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['total_courses'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Teachers</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['total_teachers'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Total Marks</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['total_marks'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.users.index') }}" class="bg-blue-50 hover:bg-blue-100 rounded-lg p-4 transition flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Manage Users</p>
                        <p class="text-sm text-gray-600">Add, edit, or remove users</p>
                    </div>
                </a>
                
                <a href="{{ route('courses.index') }}" class="bg-green-50 hover:bg-green-100 rounded-lg p-4 transition flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Manage Courses</p>
                        <p class="text-sm text-gray-600">Create and manage courses</p>
                    </div>
                </a>
                
                <a href="{{ route('marks.index') }}" class="bg-purple-50 hover:bg-purple-100 rounded-lg p-4 transition flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-award text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Manage Marks</p>
                        <p class="text-sm text-gray-600">Enter and view student marks</p>
                    </div>
                </a>
            </div>
        </div>

    @elseif(auth()->user()->isTeacher())
        <!-- Teacher Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="stat-card bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">My Courses</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['my_courses'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">My Students</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['my_students'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Pending Marks</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['pending_marks'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('courses.index') }}" class="bg-blue-50 hover:bg-blue-100 rounded-lg p-4 transition flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Manage Courses</p>
                        <p class="text-sm text-gray-600">View and manage your courses</p>
                    </div>
                </a>
                
                <a href="{{ route('marks.index') }}" class="bg-green-50 hover:bg-green-100 rounded-lg p-4 transition flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-award text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Enter Marks</p>
                        <p class="text-sm text-gray-600">Add student marks and grades</p>
                    </div>
                </a>
            </div>
        </div>

    @else(auth()->user()->isStudent())
        <!-- Student Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Enrolled Courses</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['enrolled_courses'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Completed Courses</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['completed_courses'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Average Marks</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($stats['average_marks'] ?? 0, 1) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">GPA</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($stats['gpa'] ?? 0, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('students.mycourses') }}" class="bg-blue-50 hover:bg-blue-100 rounded-lg p-4 transition flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">My Courses</p>
                        <p class="text-sm text-gray-600">View enrolled courses</p>
                    </div>
                </a>
                
                <a href="{{ route('students.mymarks') }}" class="bg-green-50 hover:bg-green-100 rounded-lg p-4 transition flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-award text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">My Marks</p>
                        <p class="text-sm text-gray-600">View marks and grades</p>
                    </div>
                </a>
            </div>
        </div>
    @endif

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Activity</h2>
        <div class="space-y-4">
            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-info-circle text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">System ready for use</p>
                    <p class="text-xs text-gray-500">All systems operational</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
