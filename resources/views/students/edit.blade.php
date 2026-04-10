@extends('layouts.app')

@section('title', 'Edit Student')

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
                        <span class="text-gray-500">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-user-edit mr-3"></i>
                    Edit Student: {{ $student->user->name }}
                </h1>
            </div>
            
            <div class="p-6">
                <!-- Current Student Info -->
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">Current Student Information</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Student ID:</span>
                            <span class="font-medium ml-2">{{ $student->roll_number ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium ml-2">{{ $student->user->email }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Enrollment:</span>
                            <span class="font-medium ml-2">{{ $student->enrollment_year ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium ml-2 px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Active</span>
                        </div>
                    </div>
                </div>
                
                <form class="space-y-6" method="POST" action="{{ route('students.update', $student->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                Personal Information
                            </h3>
                        </div>
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2"></i>Full Name *
                            </label>
                            <input type="text" id="name" name="name" required value="{{ old('name', $student->user->name) }}" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" 
                                   placeholder="Enter full name">
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2"></i>Email Address *
                            </label>
                            <input type="email" id="email" name="email" required value="{{ old('email', $student->user->email) }}" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" 
                                   placeholder="Enter email address">
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone mr-2"></i>Phone Number
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $student->user->phone) }}" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" 
                                   placeholder="Enter phone number">
                            @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2"></i>New Password
                            </label>
                            <input type="password" id="password" name="password" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" 
                                   placeholder="Leave blank to keep current password">
                            <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>Address
                            </label>
                            <textarea id="address" name="address" rows="3" 
                                      class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" 
                                      placeholder="Enter address">{{ old('address', $student->user->address) }}</textarea>
                            @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Academic Information -->
                        <div class="col-span-2 mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Academic Information
                            </h3>
                        </div>

                        <div>
                            <label for="roll_number" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-id-card mr-2"></i>Student ID *
                            </label>
                            <input type="text" id="roll_number" name="roll_number" required value="{{ old('roll_number', $student->roll_number) }}" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" 
                                   placeholder="Enter student ID">
                            @error('roll_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="enrollment_year" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2"></i>Enrollment Year *
                            </label>
                            <select id="enrollment_year" name="enrollment_year" required class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Year</option>
                                <option value="2024" {{ old('enrollment_year', $student->enrollment_year) == '2024' ? 'selected' : '' }}>2024</option>
                                <option value="2023" {{ old('enrollment_year', $student->enrollment_year) == '2023' ? 'selected' : '' }}>2023</option>
                                <option value="2022" {{ old('enrollment_year', $student->enrollment_year) == '2022' ? 'selected' : '' }}>2022</option>
                                <option value="2021" {{ old('enrollment_year', $student->enrollment_year) == '2021' ? 'selected' : '' }}>2021</option>
                            </select>
                            @error('enrollment_year') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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
                        <a href="{{ route('students.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Cancel
                        </a>
                        <div class="space-x-3">
                            <a href="{{ route('students.show', $student->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition flex items-center">
                                <i class="fas fa-eye mr-2"></i>
                                View Student
                            </a>
                            <button type="submit" class="btn-primary text-white font-bold py-3 px-6 rounded-lg flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Update Student
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
