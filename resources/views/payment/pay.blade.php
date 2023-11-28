<!-- resources/views/welcome.blade.php -->

@extends('layouts.outer')

@section('title', 'Payment')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vol_login.css') }}">

@section('content')

    <body>
        <div class="container">
            <h4 class="text-center mb-5 mt-5">Service Payment</h4>

            <div class=" box row m-5 no-gutters shadow-lg" style="background-color: #CCCCCC; border-radius: 10px">
                <div class="col-md-5 d-none d-md-block">
                    <img src="assets/images/payment/pay.png" class="img-fluid" style="min-height:100%;" />
                </div>
                <div class="col-md-6 p-5" style="background-color: #CCCCCC; border-radius: 10px">
                    <h5 class="pb-3">You've reached your limit of 4th events post</h5>
                    <h5 class="pb-3">We have only 1 plan for 3 months on <strong>5000Rwf</strong>, Pay to keep members benefits.</h5>
                    <div class="form-style">
                        <form action="{{ route('pay.payment') }}" method="post">
                            @csrf
                            <div class="form-group pb-3">
                                <input type="tel" placeholder="Phone with +250"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                    autocomplete="phone" autofocus id="phone" aria-describedby="emailHelp"
                                    name="phone">
                                @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group pb-3">
                                <input type="amount" placeholder="5000 RWf"
                                    class="form-control @error('amount') is-invalid @enderror" autocomplete="amount"
                                    id="amount" name="amount" value="5000 Rwf" readonly>
                                @error('amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="pb-2">
                                <button type="submit" style="background-color: #0081CF"
                                    class="btn w-100 font-weight-bold text-white mt-4">Pay</button>
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
