@extends('layouts.app')

@section('title', 'Marks Statistics')

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
                        <span class="text-gray-500">Statistics</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Marks Statistics
                    </h1>
                    <p class="text-purple-100 mt-2">Comprehensive analysis of student performance</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-analytics text-2xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overview Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-list text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Marks</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_marks'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-percentage text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Average</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['average_marks'], 1) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-trophy text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Highest</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['highest_marks'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-arrow-down text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Lowest</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['lowest_marks'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-graduate mr-2 text-green-500"></i>
                        Student Performance
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['passing_students'] }}</p>
                            <p class="text-sm text-gray-600">Passing Students</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['failing_students'] }}</p>
                            <p class="text-sm text-gray-600">Failing Students</p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <p class="text-sm text-gray-600 mb-2">Pass Rate</p>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            @php
                                $totalStudents = $stats['passing_students'] + $stats['failing_students'];
                                $passRate = $totalStudents > 0 ? ($stats['passing_students'] / $totalStudents) * 100 : 0;
                            @endphp
                            <div class="bg-green-600 h-3 rounded-full" style="width: {{ $passRate }}%"></div>
                        </div>
                        <p class="text-center text-sm text-gray-600 mt-1">{{ number_format($passRate, 1) }}%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-star mr-2 text-yellow-500"></i>
                        Grade Distribution
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($gradeDistribution as $grade => $count)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $grade == 'A+' || $grade == 'A' ? 'bg-green-100 text-green-800' : ($grade == 'F' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $grade }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        @php
                                            $total = array_sum($gradeDistribution);
                                            $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                                        @endphp
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 w-8">{{ $count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Grade Analysis -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-purple-500"></i>
                    Detailed Grade Analysis
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                    @foreach($gradeDistribution as $grade => $count)
                        <div class="text-center">
                            <div class="w-16 h-16 
                                {{ $grade == 'A+' || $grade == 'A' ? 'bg-green-100' : ($grade == 'F' ? 'bg-red-100' : 'bg-blue-100') }} 
                                rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="text-lg font-bold 
                                    {{ $grade == 'A+' || $grade == 'A' ? 'text-green-600' : ($grade == 'F' ? 'text-red-600' : 'text-blue-600') }}">
                                    {{ $grade }}
                                </span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $count }}</p>
                            <p class="text-xs text-gray-600">
                                @php
                                    $total = array_sum($gradeDistribution);
                                    $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                                @endphp
                                {{ number_format($percentage, 1) }}%
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
            <div class="space-x-3">
                <a href="{{ route('marks.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition flex items-center">
                    <i class="fas fa-list mr-2"></i>
                    View All Marks
                </a>
                <a href="{{ route('marks.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Mark
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
