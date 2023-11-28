<!-- resources/views/welcome.blade.php -->

@extends('layouts.outer')

@section('title', 'Verification')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/verification.css') }}">

@section('content')

    <body>
        <p class="text-center mb-4 mt-4">Check 6 digits we have sent
            to your phone number</p>
        <p class="text-center mb-5" style="background-color: rgb(255, 230, 0);">⚠ Note that if you refresh/leave this page
            whithout confirming your phone number,<br> you will be able to register again after 5 minutes
        </p>

        <div class="container shadow-lg mb-5">
            <header>
                <i class="bx bxs-check-shield"></i>
            </header>
            <h4>Enter OTP Code</h4>
            <form action="{{ route('user.org-verification') }}" method="post">
                @csrf
                <input type="hidden" name="phone_number" value="{{ session('phone_number') }}">
                <div class="col-md-9">
                    <input type="hidden" name="phone_number" value="{{ session('phone_number') }}">
                    <input id="verification_code" type="tel"
                        class="form-control @error('verification_code') is-invalid @enderror" name="verification_code"
                        value="{{ old('verification_code') }}">
                    @error('verification_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button id="verifyButton" type="submit">{{ __('Verify OTP') }}</button>
            </form>
        </div>

        <script>
            @if (session('error') || session('success'))
                Swal.fire({
                    icon: '{{ session('error') ? 'error' : 'success' }}',
                    title: '{{ session('error') ? session('error') : session('success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 6000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            @endif

            document.getElementById('verifyButton').addEventListener('click', function(event) {
                var verificationCodeInput = document.getElementById('verification_code').value.trim();
                if (verificationCodeInput === '') {
                    event.preventDefault();
                    alert('Please enter the verification code.');
                    return;
                }
            });
        </script>
    </body>
@endsection
