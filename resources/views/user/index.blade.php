<!-- resources/views/welcome.blade.php -->

@extends('layouts.outer')

@section('title', 'Index')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/index.css') }}">
<style>
    .img1, .img0 {
    animation: moveUpDown 4s infinite linear;
}

@keyframes moveUpDown {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px); /* Adjust the distance as needed */
    }
}

</style>
@section('content')

    <body>
        <div class="content">

            <div class="drop">
                <div class="left">
                    <p>Get connected with 1000+<br>
                        government & private organizations to gather<br>
                        opportunities and to deliver ones</p>
                    <button>
                        <a href="{{ route('user.create-accounts') }}">Get started <span>~ it's free</span></a>
                    </button>
                    <img class="img0" src="assets/images/sky.png" width="450px">
                </div>
                <div class="light">
                    <img class="img1" src="assets/images/person.png" width="450px">
                    <img class="img2" src="assets/images/circle.png" width="110px">
                </div>
            </div>


            {{-- middle --}}
            <div class="middle mt-5 text-center">
                <h3 class="mt-5">HOW IT WORKS</h3>
                <div class="row mt-4">
                    <div class="col-md-4 d-flex flex-column align-items-center">
                        <div class="mb-5 mt-4"
                            style="position: relative; width: 85px; height: 85px; background-color: #badaff; border-radius: 50%;">
                            <i class="fas fa-user"
                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #2550df; font-size: 43px;"></i>
                        </div>
                        <div class="box p-4 rounded" style="width: 350px; height: 190px;">
                            <!-- Set your desired width and height here -->
                            <p class="text-center mt-1 mb-4" style="font-weight: 800">Register an account<br>
                                to start.</p>
                            <p class="text-center" style="font-style: italic">To get started login either as a candidate<br>
                                or as an organization.</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-column align-items-center">
                        <div class="mb-5 mt-4"
                            style="position: relative; width: 85px; height: 85px; background-color: #ffbaba; border-radius: 50%;">
                            <i class="fab fa-wpexplorer"
                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #df2525; font-size: 3rem;"></i>
                        </div>
                        <div class="box p-4 rounded" style="width: 350px; height: 190px;">
                            <p class="text-center mt-1 mb-4" style="font-weight: 800">Explore over thousands<br>
                                of opportunities.</p>
                            <p class="text-center" style="font-style: italic">To deliver opportunities<br>
                                to candidates.</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-column align-items-center">
                        <div class="mb-5 mt-4"
                            style="position: relative; width: 85px; height: 85px; background-color: #fffeba; border-radius: 50%;">
                            <i class="fas fa-search"
                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: rgb(224, 163, 78); font-size: 2rem;"></i>
                        </div>
                        <div class="box p-4 rounded" style="width: 350px; height: 190px;">
                            <p class="text-center mt-1 mb-4" style="font-weight: 800">Find the most suitable<br>
                                for you.</p>
                            <p class="text-center" style="font-style: italic">opportunity as a candidate or candidate<br>
                                as an organization, for you</p>
                        </div>
                    </div>
                </div>
            </div>


            {{-- lower --}}
            <div class="lower mt-2 text-center">
                <h3 class="mt-5">LET'S START</h3>
                <div class="row mt-4 d-flex flex-row justify-content-around">

                    <div class='card-wrapper col-md-5'>
                        <div class='card' data-toggle-class='flipped'>
                            <div class='card-front'>
                                <div class='layer'>
                                    <h1>Start as<br>Organization</h1>
                                    <div class='corner'></div>
                                    <div class='corner'></div>
                                    <div class='corner'></div>
                                    <div class='corner'></div>
                                </div>
                            </div>
                            <div class='card-back'>
                                <div class='layer'>
                                    <div class='top'>
                                        <h2>Organization</h2>
                                    </div>
                                    <div class='bottom'>
                                        <h3 style="text-align: left;">Get connected to 5000+ volunteers
                                            to help them seek for opportunities in easy
                                            and efficient manner</h3>
                                        <a href="#"><button class="btnreg1 mt-4" style="position: absolute">Register
                                                Account</button></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='card-wrapper col-md-5'>
                        <div class='card' data-toggle-class='flipped'>
                            <div class='card-front1'>
                                <div class='layer'>
                                    <h1>Start as<br>Candidate</h1>
                                    <div class='corner'></div>
                                    <div class='corner'></div>
                                    <div class='corner'></div>
                                    <div class='corner'></div>
                                </div>
                            </div>
                            <div class='card-back1'>
                                <div class='layer'>
                                    <div class='top'>
                                        <h2>Candidate </h2>
                                    </div>
                                    <div class='bottom'>
                                        <h3 style="text-align: left;">Get yourself connected direcldirectly
                                            with 500+ organizations to give you different
                                            kinds opportunities</h3>
                                        <a href="#"><button class="btnreg2 mt-4" style="position: absolute">Register
                                                Account</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- share --}}
            <div class="share mt-5">
                <h3>Share with friends</h3>
                <div class="sites mt-4 d-flex flex-row justify-content-start">
                    <a href="https://twitter.com/intent/tweet?url=www.volunteerportal.com" target="_blank">
                        <img style="border-radius: 10px; margin-right: 16px;" src="assets/images/sites/Twitter-X.jpg"
                            width="40px">
                    </a>
                    <a href="https://api.whatsapp.com/send?text=Check out www.volunteerportal.com" target="_blank">
                        <img style="margin-right: 11px;" src="assets/images/sites/Whatsapp.png" width="40px">
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=www.volunteerportal.com" target="_blank">
                        <img style="margin-right: 3px; margin-top: -4px;" src="assets/images/sites/Facebook.png"
                            width="50px">
                    </a>
                    <a href="https://www.instagram.com/" target="_blank">
                        <img style="margin-top: -5px;" src="assets/images/sites/Instagram.png" width="52px">
                    </a>
                </div>
            </div>
        </div>

    <script src="{{ asset('assets/js/index.js') }}"></script>
    </body>
@endsection

