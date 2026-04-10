@extends('layouts.app')

@section('title', 'Mark Details')

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
                        <a href="{{ route('marks.index') }}" class="text-gray-700 hover:text-gray-900">Marks</a>
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

        <!-- Mark Details Header -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-award mr-3"></i>
                        Mark Details
                    </h1>
                    <p class="text-purple-100 mt-2">{{ $mark->course->name }} - {{ ucfirst($mark->exam_type) }}</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <span class="text-white text-3xl font-bold">{{ $mark->grade }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mark Information -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                            Mark Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500">Student</p>
                                <p class="font-medium text-gray-900">{{ $mark->student->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $mark->student->roll_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Course</p>
                                <p class="font-medium text-gray-900">{{ $mark->course->name }}</p>
                                <p class="text-sm text-gray-600">{{ $mark->course->code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Exam Type</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($mark->exam_type) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Score</p>
                                <div class="flex items-center space-x-2">
                                    <p class="text-2xl font-bold text-gray-900">{{ $mark->marks }}/100</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $mark->grade == 'A+' || $mark->grade == 'A' ? 'bg-green-100 text-green-800' : ($mark->grade == 'F' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $mark->grade }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $mark->marks }}%"></div>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Remarks</p>
                                <p class="font-medium text-gray-900">{{ $mark->remarks ?: 'No remarks provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Analysis -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden mt-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-green-500"></i>
                            Performance Analysis
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                                </div>
                                <p class="text-sm text-gray-600">Status</p>
                                <p class="font-bold text-gray-900">{{ $mark->marks >= 50 ? 'Pass' : 'Fail' }}</p>
                            </div>
                            <div class="text-center">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-percentage text-blue-600 text-2xl"></i>
                                </div>
                                <p class="text-sm text-gray-600">Percentage</p>
                                <p class="font-bold text-gray-900">{{ $mark->marks }}%</p>
                            </div>
                            <div class="text-center">
                                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-trophy text-purple-600 text-2xl"></i>
                                </div>
                                <p class="text-sm text-gray-600">Grade Point</p>
                                <p class="font-bold text-gray-900">{{ $mark->marks >= 90 ? '4.0' : ($mark->marks >= 85 ? '3.7' : ($mark->marks >= 80 ? '3.3' : ($mark->marks >= 75 ? '3.0' : ($mark->marks >= 70 ? '2.7' : ($mark->marks >= 65 ? '2.3' : ($mark->marks >= 50 ? '2.0' : '0.0')))))) }}</p>
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
                        @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                            <a href="{{ route('marks.edit', $mark->id) }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Mark
                            </a>
                            <form method="POST" action="{{ route('marks.destroy', $mark->id) }}" onsubmit="return confirm('Are you sure you want to delete this mark?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete Mark
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('marks.index') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center justify-center">
                            <i class="fas fa-list mr-2"></i>
                            All Marks
                        </a>
                    </div>
                </div>

                <!-- Related Information -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-link mr-2 text-blue-500"></i>
                            Related Information
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Course Teacher</p>
                            <p class="font-medium text-gray-900">{{ $mark->course->teacher ? $mark->course->teacher->name : 'Not Assigned' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Credit Hours</p>
                            <p class="font-medium text-gray-900">{{ $mark->course->credit_hours }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Marked Date</p>
                            <p class="font-medium text-gray-900">{{ $mark->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Last Updated</p>
                            <p class="font-medium text-gray-900">{{ $mark->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('marks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Marks
            </a>
            <div class="space-x-3">
                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                    <a href="{{ route('marks.edit', $mark->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Mark
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
