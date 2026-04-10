@extends('layouts.admin')
@section('title', 'Course Details')
@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Name:</strong> {{ $course->course_name }}</p>
        <p><strong>Code:</strong> {{ $course->course_code }}</p>
        <p><strong>Credit Hours:</strong> {{ $course->credit_hours }}</p>
        <p><strong>Teacher:</strong> {{ $course->teacher?->name ?? 'Not assigned' }}</p>
        <p><strong>Enrolled Students:</strong> {{ $course->students->count() }}</p>
    </div>
</div>
@endsection
