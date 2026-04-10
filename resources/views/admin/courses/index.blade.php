@extends('layouts.admin')
@section('title', 'Courses')
@section('content')
<a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Add Course</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Course Name</th>
            <th>Code</th>
            <th>Credit Hours</th>
            <th>Teacher</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($courses as $course)
            <tr>
                <td>{{ $course->course_name }}</td>
                <td>{{ $course->course_code }}</td>
                <td>{{ $course->credit_hours }}</td>
                <td>{{ $course->teacher?->name ?? 'Not assigned' }}</td>
                <td>
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-success">View</a>
                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this course?')" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">No courses found.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $courses->links() }}
@endsection
