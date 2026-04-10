@extends('layouts.app')

@section('title', 'Create Course')

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
                        <a href="{{ route('courses.index') }}" class="text-gray-700 hover:text-gray-900">Courses</a>
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
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-plus-circle mr-3"></i>
                    Create New Course
                </h1>
            </div>
            
            <div class="p-6">
                <form class="space-y-6" method="POST" action="{{ route('courses.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-book mr-2"></i>Course Name *
                            </label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 placeholder-gray-400" 
                                   placeholder="Enter course name">
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-barcode mr-2"></i>Course Code *
                            </label>
                            <input type="text" id="code" name="code" required value="{{ old('code') }}" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 placeholder-gray-400" 
                                   placeholder="e.g., CS101">
                            @error('code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="credit_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clock mr-2"></i>Credit Hours *
                            </label>
                            <input type="number" id="credit_hours" name="credit_hours" required min="1" max="10" value="{{ old('credit_hours', 3) }}" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 placeholder-gray-400" 
                                   placeholder="Enter credit hours">
                            @error('credit_hours') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>Assign Teacher
                            </label>
                            <select id="teacher_id" name="teacher_id" class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">Select a teacher (optional)</option>
                                @foreach($teachers ?? [] as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('teacher_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-2"></i>Description
                        </label>
                        <textarea id="description" name="description" rows="4" 
                                  class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 placeholder-gray-400" 
                                  placeholder="Enter course description">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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
                        <a href="{{ route('courses.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Cancel
                        </a>
                        <div class="space-x-3">
                            <a href="{{ route('courses.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition flex items-center">
                                <i class="fas fa-list mr-2"></i>
                                View All Courses
                            </a>
                            <button type="submit" class="btn-primary text-white font-bold py-3 px-6 rounded-lg flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Create Course
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
