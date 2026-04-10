@extends('layouts.admin')

@section('title', 'Student Details')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Student Details</h3>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">ID</th>
                <td>{{ $student->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $student->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $student->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $student->phone }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $student->address }}</td>
            </tr>
            <tr>
                <th>Enrollment Year</th>
                <td>{{ $student->enrollment_year }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $student->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $student->updated_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>

        <h5>Enrolled Courses</h5>
        <ul>
            @forelse($student->courses as $course)
                <li>{{ $course->course_name }} ({{ $course->course_code }})</li>
            @empty
                <li>No courses assigned.</li>
            @endforelse
        </ul>
        
        <div class="mt-3">
            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection