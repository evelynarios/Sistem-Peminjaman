@extends('layouts.main')

@section('container')
    <style>
        .card-body {
            background-color: #03045e;
        }
    </style>
    <div class="row justify-content-center my-5">
        <div class="col-lg-4">
            <main class="form-registration w-100 m-auto">
                <h3 class="text-center ">Hello</h3>
                <h1 class=" mb-3 fw-normal text-center">Selamat Datang di Sistem Peminjaman UNIB !</h1>
                <div class="card-body rounded">
                    <div class="px-3 mt-2">
                        <h4 class="text-center text-white">Register</h4>
                        <form action="/register" method="POST">
                            @csrf
                            <div class="form-group mt-2">
                                <label class="label-access text-white mb-2">Full Name</label>
                                <input type="text" class="form-control rounded-top @error('name') is-invalid @enderror"
                                    id="name" placeholder="Full Name" name="name" required
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label class="label-access text-white mb-2">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" placeholder="username" name="username" required
                                    value="{{ old('username') }}">
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label class="label-access text-white mb-2">Email address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" placeholder="name@example.com" name="email" required
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- TAMBAHAN
                            <div class="form-group mt-3 form-check form-switch">
                                <label class="form-check-label text-white" for="isAdmin">Is Admin</label>
                                <input class="form-check-input" type="checkbox" id="isAdmin" name="isAdmin"
                                    {{ old('isAdmin') ? 'checked' : '' }}>
                            </div> --}}
                            {{-- TAMBAHAN --}}
                            <div class="form-group mt-3">
                                <label class="label-access text-white mb-2">NPM</label>
                                <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim"
                                    placeholder="NPM" name="nim" required value="{{ old('nim') }}" maxlength="10">
                                @error('nim')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label class="label-access text-white mb-2">Password</label>
                                <input type="password"
                                    class="form-control rounded-bottom @error('password') is-invalid @enderror"
                                    id="password" placeholder="Password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button class="btn w-100 py-2 mt-4" type="submit"
                                style="background-color: orange; color: white; border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06); transition: all 0.3s ease-in-out;"
                                onmouseover="this.style.backgroundColor='darkorange'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 10px rgba(0, 0, 0, 0.15), 0 2px 4px rgba(0, 0, 0, 0.1)';"
                                onmouseout="this.style.backgroundColor='orange'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06)';">
                                Register
                            </button>

                        </form>
                        <small class="d-block text-center mt-3" style="color: white;">
                            Already registered ? 
                            <a href="/login">Login</a>
                        </small>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
