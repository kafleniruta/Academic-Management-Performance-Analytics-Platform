@extends('layouts.app')

@section('title', 'Create Mark')

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
                        <span class="text-gray-500">Create</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-plus-square mr-3"></i>
                    Create New Mark
                </h1>
            </div>
            
            <div class="p-6">
                <form class="space-y-6" method="POST" action="{{ route('marks.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user-graduate mr-2"></i>Select Student *
                            </label>
                            <select id="student_id" name="student_id" required class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Choose a student</option>
                                @foreach($students ?? [] as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->user->name }} ({{ $student->roll_number ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                            @error('student_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-book mr-2"></i>Select Course *
                            </label>
                            <select id="course_id" name="course_id" required class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Choose a course</option>
                                @foreach($courses ?? [] as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }} ({{ $course->code }})</option>
                                @endforeach
                            </select>
                            @error('course_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="exam_type" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clipboard-list mr-2"></i>Exam Type *
                            </label>
                            <select id="exam_type" name="exam_type" required class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Select exam type</option>
                                <option value="midterm" {{ old('exam_type') == 'midterm' ? 'selected' : '' }}>Midterm</option>
                                <option value="final" {{ old('exam_type') == 'final' ? 'selected' : '' }}>Final</option>
                                <option value="assignment" {{ old('exam_type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                                <option value="quiz" {{ old('exam_type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                <option value="project" {{ old('exam_type') == 'project' ? 'selected' : '' }}>Project</option>
                            </select>
                            @error('exam_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="marks" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-percentage mr-2"></i>Marks (0-100) *
                            </label>
                            <input type="number" id="marks" name="marks" required min="0" max="100" step="0.1" value="{{ old('marks') }}" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" 
                                   placeholder="Enter marks (0-100)">
                            @error('marks') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment mr-2"></i>Remarks
                        </label>
                        <textarea id="remarks" name="remarks" rows="3" 
                                  class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" 
                                  placeholder="Enter any remarks or comments">{{ old('remarks') }}</textarea>
                        @error('remarks') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Grade Preview -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Grade Information
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div class="text-center">
                                <span class="block font-bold text-green-600">A+</span>
                                <span class="text-gray-500">90-100</span>
                            </div>
                            <div class="text-center">
                                <span class="block font-bold text-green-500">A</span>
                                <span class="text-gray-500">85-89</span>
                            </div>
                            <div class="text-center">
                                <span class="block font-bold text-blue-500">B+</span>
                                <span class="text-gray-500">80-84</span>
                            </div>
                            <div class="text-center">
                                <span class="block font-bold text-blue-400">B</span>
                                <span class="text-gray-500">75-79</span>
                            </div>
                            <div class="text-center">
                                <span class="block font-bold text-yellow-500">C+</span>
                                <span class="text-gray-500">70-74</span>
                            </div>
                            <div class="text-center">
                                <span class="block font-bold text-yellow-400">C</span>
                                <span class="text-gray-500">65-69</span>
                            </div>
                            <div class="text-center">
                                <span class="block font-bold text-orange-500">D</span>
                                <span class="text-gray-500">50-64</span>
                            </div>
                            <div class="text-center">
                                <span class="block font-bold text-red-500">F</span>
                                <span class="text-gray-500">Below 50</span>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <div>
                                    <p class="font-medium">Please fix the following errors:</p>
                                    <ul class="mt-2 list-disc list-inside text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="{{ route('marks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Cancel
                        </a>
                        <div class="space-x-3">
                            <a href="{{ route('marks.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition flex items-center">
                                <i class="fas fa-list mr-2"></i>
                                View All Marks
                            </a>
                            <button type="submit" class="btn-primary text-white font-bold py-3 px-6 rounded-lg flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Create Mark
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('marks').addEventListener('input', function() {
    const marks = parseFloat(this.value);
    let grade = '';
    
    if (marks >= 90) grade = 'A+';
    else if (marks >= 85) grade = 'A';
    else if (marks >= 80) grade = 'B+';
    else if (marks >= 75) grade = 'B';
    else if (marks >= 70) grade = 'C+';
    else if (marks >= 65) grade = 'C';
    else if (marks >= 50) grade = 'D';
    else grade = 'F';
    
    // You could display the grade here if needed
});
</script>
@endpush
@endsection
