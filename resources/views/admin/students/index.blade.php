@extends('layouts.admin.students.index')
@section('title', 'Students List')
@section('content')

<div class="container mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Students List</h2>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">+ Add Student</a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Wrapper -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Enrollment Year</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->enrollment_year }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    {{-- View Button --}}
                                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-success">View</a>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>

                                    {{-- Delete Form --}}
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No students found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>

@endsection