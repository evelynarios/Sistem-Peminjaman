@extends ('layouts.admin')

@section('content')
    <style>
        * {
            font-family: 'Open Sans', sans-serif;
        }
    </style>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container-lg justify-content-center">
        <h1 class="text-center mt-5 mb-5">Manajemen Akun Peminjam</h1>
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card card-body" style="background-color: #F4F5F6;">
            <table class="table table-responsive table-hover">
                <thead style="background-color: #03045e; color:azure">
                    <tr>
                        <th scope="col" style="width: 100px;">#</th>
                        <th scope="col" style="width: 200px;">Nama</th>
                        <th scope="col" style="width: 250px;">Username</th>
                        <th scope="col" style="width: 300px;">Email</th>
                        <th scope="col" style="width: 150px;">NIM</th>
                        <th scope="col" style="width: 150px;">Role</th>
                        <th scope="col" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->nim }}</td>
                            <td>{{ $user->isAdmin == 1 ? 'Admin' : 'Peminjam' }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
