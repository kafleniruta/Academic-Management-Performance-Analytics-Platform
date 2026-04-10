@extends('layouts.admin')

@section('title', 'Edit Student')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Student</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $student->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email', $student->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Phone *</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" value="{{ old('phone', $student->phone) }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Address *</label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address" rows="3" required>{{ old('address', $student->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="enrollment_year" class="form-label">Enrollment Year *</label>
                <select class="form-control @error('enrollment_year') is-invalid @enderror" 
                        id="enrollment_year" name="enrollment_year" required>
                    @for($year = date('Y'); $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ old('enrollment_year', $student->enrollment_year) == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
                @error('enrollment_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Assigned Courses</label>
                <div class="border rounded p-2" style="max-height: 180px; overflow:auto;">
                    @forelse($courses as $course)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="course_ids[]"
                                   id="course_{{ $course->id }}" value="{{ $course->id }}"
                                   {{ in_array($course->id, old('course_ids', $enrolledCourseIds ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="course_{{ $course->id }}">
                                {{ $course->course_name }} ({{ $course->course_code }})
                            </label>
                        </div>
                    @empty
                        <small class="text-muted">No courses available.</small>
                    @endforelse
                </div>
            </div>
            
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update Student</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection