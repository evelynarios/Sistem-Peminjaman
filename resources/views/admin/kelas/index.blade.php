@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Manage Classes</h1>

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('delete'))
            <div class="alert alert-danger">
                {{ session('delete') }}
            </div>
        @endif

        <a href="{{ route('kelas.create') }}" class="btn btn-primary mb-3">Add Class</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Class Name</th>
                    <th>Facility</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach ($kelas as $class)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $class->room }}</td>
                        <td>{{ $class->facility->name ?? 'No Facility Assigned' }}</td>
                        <td>
                            <a href="{{ route('kelas.edit', $class->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('kelas.destroy', $class->id) }}" method="POST" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
