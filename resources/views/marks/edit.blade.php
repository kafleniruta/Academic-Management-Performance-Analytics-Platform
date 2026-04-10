@extends('layouts.app')

@section('title', 'Edit Mark')

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
                        <span class="text-gray-500">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-3"></i>
                    Edit Mark Entry
                </h1>
            </div>
            
            <div class="p-6">
                <!-- Current Mark Info -->
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">Current Mark Information</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Student:</span>
                            <span class="font-medium ml-2">{{ $mark->student->user->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Course:</span>
                            <span class="font-medium ml-2">{{ $mark->course->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Exam Type:</span>
                            <span class="font-medium ml-2">{{ ucfirst($mark->exam_type) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Current Grade:</span>
                            <span class="font-medium ml-2 px-2 py-1 rounded-full text-xs {{ $mark->grade == 'A+' || $mark->grade == 'A' ? 'bg-green-100 text-green-800' : ($mark->grade == 'F' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">{{ $mark->grade }}</span>
                        </div>
                    </div>
                </div>
                
                <form class="space-y-6" method="POST" action="{{ route('marks.update', $mark->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user-graduate mr-2"></i>Select Student *
                            </label>
                            <select id="student_id" name="student_id" required class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Choose a student</option>
                                @foreach($students ?? [] as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $mark->student_id) == $student->id ? 'selected' : '' }}>{{ $student->user->name }} ({{ $student->roll_number ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                            @error('student_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-book mr-2"></i>Select Course *
                            </label>
                            <select id="course_id" name="course_id" required class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Choose a course</option>
                                @foreach($courses ?? [] as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $mark->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name }} ({{ $course->code }})</option>
                                @endforeach
                            </select>
                            @error('course_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="exam_type" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clipboard-list mr-2"></i>Exam Type *
                            </label>
                            <select id="exam_type" name="exam_type" required class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Select exam type</option>
                                <option value="midterm" {{ old('exam_type', $mark->exam_type) == 'midterm' ? 'selected' : '' }}>Midterm</option>
                                <option value="final" {{ old('exam_type', $mark->exam_type) == 'final' ? 'selected' : '' }}>Final</option>
                                <option value="assignment" {{ old('exam_type', $mark->exam_type) == 'assignment' ? 'selected' : '' }}>Assignment</option>
                                <option value="quiz" {{ old('exam_type', $mark->exam_type) == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                <option value="project" {{ old('exam_type', $mark->exam_type) == 'project' ? 'selected' : '' }}>Project</option>
                            </select>
                            @error('exam_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="marks" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-percentage mr-2"></i>Marks (0-100) *
                            </label>
                            <input type="number" id="marks" name="marks" required min="0" max="100" step="0.1" value="{{ old('marks', $mark->marks) }}" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 placeholder-gray-400" 
                                   placeholder="Enter marks (0-100)">
                            @error('marks') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment mr-2"></i>Remarks
                        </label>
                        <textarea id="remarks" name="remarks" rows="3" 
                                  class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 placeholder-gray-400" 
                                  placeholder="Enter any remarks or comments">{{ old('remarks', $mark->remarks) }}</textarea>
                        @error('remarks') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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
                            <a href="{{ route('marks.show', $mark->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition flex items-center">
                                <i class="fas fa-eye mr-2"></i>
                                View Mark
                            </a>
                            <button type="submit" class="btn-primary text-white font-bold py-3 px-6 rounded-lg flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Update Mark
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
