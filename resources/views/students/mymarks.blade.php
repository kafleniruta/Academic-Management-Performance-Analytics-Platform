@extends('layouts.app')

@section('title', 'My Marks')

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
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">My Marks</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-award mr-3"></i>
                        My Marks
                    </h1>
                    <p class="text-green-100 mt-2">View your academic performance and grades</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-list text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Marks</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $marks->total() }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ $marks->avg('marks') ? number_format($marks->avg('marks'), 1) : 'N/A' }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ $marks->max('marks') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-star text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">GPA</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $marks->avg('marks') ? number_format($marks->avg('marks') / 20, 2) : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grade Distribution -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Grade Distribution</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $gradeA = $marks->where('marks', '>=', 90)->count();
                        $gradeB = $marks->whereBetween('marks', [80, 89])->count();
                        $gradeC = $marks->whereBetween('marks', [70, 79])->count();
                        $gradeD = $marks->whereBetween('marks', [50, 69])->count();
                        $gradeF = $marks->where('marks', '<', 50)->count();
                    @endphp
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-green-600 font-bold text-lg">A</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $gradeA }}</p>
                        <p class="text-sm text-gray-600">90-100%</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-blue-600 font-bold text-lg">B</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $gradeB }}</p>
                        <p class="text-sm text-gray-600">80-89%</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-yellow-600 font-bold text-lg">C</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $gradeC }}</p>
                        <p class="text-sm text-gray-600">70-79%</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-orange-600 font-bold text-lg">D</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $gradeD }}</p>
                        <p class="text-sm text-gray-600">50-69%</p>
                    </div>
                </div>
                
                @if($gradeF > 0)
                    <div class="text-center mt-4">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-red-600 font-bold text-lg">F</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $gradeF }}</p>
                        <p class="text-sm text-gray-600">Below 50%</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Marks Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Detailed Marks</h2>
            </div>
            
            @if($marks->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($marks as $mark)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $mark->course->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $mark->course->code }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($mark->exam_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $mark->marks }}/100</div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $mark->marks }}%"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $grade = '';
                                            $gradeColor = '';
                                            if ($mark->marks >= 90) { $grade = 'A+'; $gradeColor = 'bg-green-100 text-green-800'; }
                                            elseif ($mark->marks >= 85) { $grade = 'A'; $gradeColor = 'bg-green-100 text-green-800'; }
                                            elseif ($mark->marks >= 80) { $grade = 'B+'; $gradeColor = 'bg-blue-100 text-blue-800'; }
                                            elseif ($mark->marks >= 75) { $grade = 'B'; $gradeColor = 'bg-blue-100 text-blue-800'; }
                                            elseif ($mark->marks >= 70) { $grade = 'C+'; $gradeColor = 'bg-yellow-100 text-yellow-800'; }
                                            elseif ($mark->marks >= 65) { $grade = 'C'; $gradeColor = 'bg-yellow-100 text-yellow-800'; }
                                            elseif ($mark->marks >= 50) { $grade = 'D'; $gradeColor = 'bg-orange-100 text-orange-800'; }
                                            else { $grade = 'F'; $gradeColor = 'bg-red-100 text-red-800'; }
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gradeColor }}">
                                            {{ $grade }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $mark->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $mark->remarks ?: 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $marks->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-award text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No marks available yet</h3>
                    <p class="text-gray-600 mb-6">Your marks haven't been entered yet. Check back later for updates.</p>
                    <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-lg transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
