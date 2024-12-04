@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Add New Class</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="room">Class Room</label>
                <input type="text" class="form-control" id="room" name="room" value="{{ old('room') }}" required>
            </div>

            <div class="form-group">
                <label for="id_facility">Facility</label>
                <select class="form-control" id="id_facility" name="id_facility" required>
                    @foreach ($facilities as $facility)
                        <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save Class</button>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
