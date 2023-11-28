<!-- resources/views/welcome.blade.php -->

@extends('layouts.outer')

@section('title', 'Login')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vol_login.css') }}">

@section('content')

    <body>
        <div class="container">
            <h4 class="text-center mb-5 mt-5"></h4>

            <div class=" box row m-5 no-gutters shadow-lg" style="background-color: #CCCCCC; border-radius: 10px">
                <div class="col-md-5 d-none d-md-block">
                    <img src="assets/images/admin/admin.png" class="img-fluid" style="min-height:100%;" />
                </div>
                <div class="col-md-6 p-5" style="background-color: #CCCCCC; border-radius: 10px">
                    <h3 class="pb-3">Admin Login Form</h3>
                    <div class="form-style">
                        <form action="{{ route('admin.login') }}" method="post">
                            @csrf
                            <div class="form-group pb-3">
                                <input type="email" placeholder="Email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    autocomplete="email" autofocus id="email" aria-describedby="emailHelp"
                                    name="email">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group pb-3">
                                <input type="password" placeholder="Password"
                                    class="form-control @error('password') is-invalid @enderror" autocomplete="password"
                                    id="password" name="password">
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="pb-2">
                                <button type="submit" style="background-color: #0081CF"
                                    class="btn w-100 font-weight-bold text-white mt-4">Login</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script>
            @if (session('error') || session('success'))
                Swal.fire({
                    icon: '{{ session('error') ? 'error' : 'success' }}',
                    title: '{{ session('error') ? session('error') : session('success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            @endif
        </script>
    </body>
@endsection
