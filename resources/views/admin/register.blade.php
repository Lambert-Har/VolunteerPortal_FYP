@extends('layouts.outer')

@section('title', 'Register')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vol-signup.css') }}">

@section('content')

    <body>
        <div class="container">
            <h4 class="text-center mb-5 mt-5">Admin Registration</h4>

            <div class="row m-5 no-gutters justify-content-center">
                <div class="col-md-6  p-5 no-gutters shadow-lg" style="background-color: #CCCCCC; border-radius: 10px">
                    <h3 class="pb-3">Register</h3>
                    <form action="{{ route('admin.register') }}" method="POST" enctype="multipart/form-data"
                        autocomplete="on">
                        @csrf
                        <div class="form-group">
                            <input id="name" type="text" placeholder="Full name"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <input id="email" name="email" type="email" placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" placeholder="Password"
                                class="form-control  @error('password') is-invalid @enderror" name="password"
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control"
                            name="password_confirmation" autocomplete="new-password">
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold">Sign Up</button>
                        </div>
                    </form>
                    <div class="pt-4 text-center">
                        Have an account? <a href="{{ route('admin.login') }}">Login</a>
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
