<!-- resources/views/welcome.blade.php -->

@extends('layouts.outer')

@section('title', 'Confirmation')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vol_login.css') }}">

@section('content')

    <body>
        <div class="container">
            <h4 class="text-center mb-5 mt-5">Payment Confirmation</h4>

            <div class="box row m-5 no-gutters shadow-lg" style="background-color: #CCCCCC; border-radius: 10px">
                <div class="col-md-5 d-none d-md-block">
                    <img src="assets/images/payment/confirm.png" class="img-fluid" style="min-height:100%;" />
                </div>
                <div class="col-md-6 p-5 mt-5" style="background-color: #CCCCCC; border-radius: 10px; text-align: center;">
                    <h3 class="pb-3">Your payment is successfully processed</h3>
                    <div class="form-style">
                        <a href="{{ route('pay.confirm') }}" class="logout">
                            <button type="button" class="btn btn-success"><i class='bx bx-log-out-circle'></i> Back to Login</button>
                        </a>
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
