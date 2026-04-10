@extends('layouts.admin')
@section('title', 'Teacher Details')
@section('content')

<div class="container mt-4">
    {{-- Display success/error messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($teacher))
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Teacher Details</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">ID</th>
                        <td>{{ $teacher->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $teacher->name }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $teacher->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $teacher->email }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $teacher->address }}</td>
                    </tr>
                    <tr>
                        <th>Joining Year</th>
                        <td>{{ $teacher->joining_year }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $teacher->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $teacher->updated_at->format('M d, Y h:i A') }}</td>
                    </tr>
                </table>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this teacher?');" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            <h5>Teacher not found</h5>
            <p>The requested teacher record does not exist.</p>
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary mt-2">Back to Teachers List</a>
        </div>
    @endif
</div>

@endsection