@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Class</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="room">Class room</label>
                <input type="text" class="form-control" id="room" name="room" value="{{ old('room', $kelas->room) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="id_facility">Facility</label>
                <select class="form-control" id="id_facility" name="id_facility" required>
                    @foreach ($facilities as $facility)
                        <option value="{{ $facility->id }}" {{ $kelas->id_facility == $facility->id ? 'selected' : '' }}>
                            {{ $facility->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Class</button>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
