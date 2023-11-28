<!-- resources/views/welcome.blade.php -->

@extends('layouts.outer')

@section('title', 'Create Account')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/acc_creation.css') }}">


@section('content')

    <body>
        <div class="container">
            <h4 class="text-center mb-5">LET'S GO</h4>

            <div class="drop row justify-content-around mb-5">
                <div>
                    <div class="left d-flex flex-column mb-5"
                        style="background-image: url('assets/images/registration/regvol1.png'); background-size: 100% 100%; padding: 20px;">
                        <!-- Content for the left column -->
                        <h5 class="mt-1 mb-3">Candidate</h5>
                        <p>Get an account by directly connect your self<br>
                            with 500+ organizations to give you different<br> 
                            kinds opportunities</p>
                        <div class="action mt-3 d-flex justify-content-between">
                            <a  href="{{ route('user.vol-login') }}"><button  style="color: #4D49FF">Login</button></a>
                            <a href="{{ route('user.vol-signup') }}"><button  style="color: #4D49FF">Signup</button></a>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="right d-flex flex-column"
                        style="background-image: url('assets/images/registration/regorg2.png'); background-size: 100% 100%; padding: 20px;">
                        <!-- Content for the right column -->
                        <h5 class="mt-1 mb-3">Organization</h5>
                        <p>Get connected with 5000+ volunteers<br>
                            from different locations to help them seek for<br>
                            opportunities in easy and efficient manner</p>
                        <div class="action mt-3 mb-3 d-flex justify-content-between">
                            <a href="{{ route('user.org-login') }}"><button style="color: #FF9090">Login</button></a>
                            <a href="{{ route('user.org-signup') }}"><button style="color: #FF9090">Signup</button></a>
                        </div>
                    </div>
                </div>
            </div>



            <div class="mb-5">
                <p>"Welcome to our platform! Whether you're a dedicated volunteer or a valued organization, we're thrilled
                    to have you here.
                    This login page is your gateway to a world of meaningful collaboration and positive impact. For
                    volunteers, it's your
                    opportunity to access exciting projects, contribute your expertise, and make a difference in causes you
                    care about.
                    For organizations, this is where you can manage and coordinate your initiatives, connect with passionate
                    individuals, and
                    amplify your mission. Together, we're building a vibrant community driven by innovation, compassion, and
                    shared goals.
                    So go ahead, log in, and let's work together to create a brighter future."</p>
            </div>
        </div>

    </body>
@endsection
