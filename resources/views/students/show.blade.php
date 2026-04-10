@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('students.index') }}" class="text-gray-700 hover:text-gray-900">Students</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Student Profile Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <span class="text-white text-3xl font-bold">{{ strtoupper(substr($student->user->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $student->user->name }}</h1>
                        <p class="text-blue-100">{{ $student->roll_number ?? 'N/A' }}</p>
                        <p class="text-blue-100 text-sm">{{ $student->user->email }}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('students.edit', $student->id) }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <!-- Student Information -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Personal Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-500"></i>
                            Personal Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="font-medium text-gray-900">{{ $student->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email Address</p>
                                <p class="font-medium text-gray-900">{{ $student->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone Number</p>
                                <p class="font-medium text-gray-900">{{ $student->user->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="font-medium text-gray-900">{{ $student->user->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden mt-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-graduation-cap mr-2 text-green-500"></i>
                            Academic Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500">Student ID</p>
                                <p class="font-medium text-gray-900">{{ $student->roll_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Enrollment Year</p>
                                <p class="font-medium text-gray-900">{{ $student->enrollment_year ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Account Created</p>
                                <p class="font-medium text-gray-900">{{ $student->user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Panel -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                            Quick Actions
                        </h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('students.edit', $student->id) }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Student
                        </a>
                        <a href="{{ route('students.mymarks', $student->id) }}" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                            <i class="fas fa-chart-line mr-2"></i>
                            View Marks
                        </a>
                        <a href="{{ route('students.mycourses', $student->id) }}" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                            <i class="fas fa-book mr-2"></i>
                            View Courses
                        </a>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-purple-500"></i>
                            Statistics
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Courses</span>
                            <span class="font-bold text-gray-900">{{ $student->courses->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Marks</span>
                            <span class="font-bold text-gray-900">{{ $student->marks->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Average Grade</span>
                            <span class="font-bold text-gray-900">{{ $student->marks->avg('marks') ? number_format($student->marks->avg('marks'), 1) : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('students.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Students
            </a>
            <div class="space-x-3">
                <a href="{{ route('students.edit', $student->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Student
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
