@extends('layouts.admin')
@section('title', 'Add Course')
@section('content')
<form method="POST" action="{{ route('courses.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Course Name</label>
        <input type="text" name="course_name" value="{{ old('course_name') }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Course Code</label>
        <input type="text" name="course_code" value="{{ old('course_code') }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Credit Hours</label>
        <input type="number" name="credit_hours" value="{{ old('credit_hours') }}" min="1" max="6" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Assigned Teacher</label>
        <select name="teacher_id" class="form-select">
            <option value="">Select teacher</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ (string) old('teacher_id') === (string) $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
</form>
@endsection
