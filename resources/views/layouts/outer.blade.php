<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- css resources -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">

    <!-- js resources -->
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Include Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Link to app.css using asset() -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/outer.css') }}">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-custom navbar-mainbg">

        <a class="navbar-brand navbar-logo" href="{{ route('user.index') }}"
            style="padding-left: 20px; cursor: pointer;">
            <img src="assets/images/logo.png" width="50px"></a>
        <p style="font-weight: bold; position: absolute; padding-top: 15px; padding-left: 80px">Volunteer<br>Portal</p>

        <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="padding-right: 6px;">
            <ul class="navbar-nav ml-auto">
                <div class="hori-selector">
                    <div class="left"></div>
                    <div class="right"></div>
                </div>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('user.index') }}"><i class="fas fa-tachometer-alt"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="far fa-address-book"></i>Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="far fa-clone"></i>Support</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="far fa-calendar-alt"></i>Contact</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.ad-login') }}"><i class="fa fa-chart-bar"></i>Admin</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.create-accounts') }}"><i class="far fa-copy"></i>LOGIN</a>
                </li>
            </ul>
        </div>
    </nav>


    <main>
        @yield('content')
    </main>

    <footer>
        <img src="assets/images/footer.png" alt="" width="400px">
        <div class="allinks" style="background-color: #cccccc">
            <div class="links row mt-3 d-flex flex-row justify-content-around">
                <div class="quote mt-4 col-md-3 d-flex flex-column align-items-center">
                    <h5>Quote</h5>
                    <p class="text-center">“Don't wait for extraordinary opportunities.<br>
                        Seize common occasions and make them great.”<br>
                        <span style="font-weight: 600; font-style: italic">– Orison Swett Marden</span>
                    </p>
                </div>
                <div class="vol mt-4 col-md- d-flex flex-column align-items-center">
                    <h5>For Volunteers</h5>
                    <div>
                        <li><a href="#">Candidate dashboard</a></li>
                        <li><a href="#">Browse opportunities</a></li>
                        <li><a href="#">Opportunity Alerts</a></li>
                    </div>
                </div>
                <div class="org mt-4 col-md-3 d-flex flex-column align-items-center">
                    <h5>For Organizations</h5>
                    <div>
                        <li><a href="#">Employer Dashboard</a></li>
                        <li><a href="#">Post an Opportunity</a></li>
                        <li><a href="#">Hire Candidates</a></li>
                    </div>
                </div>
                <div class="cont mt-4 col-md-3 d-flex flex-column align-items-center">
                    <h5>Contact Us</h5>
                    <div style="list-style-type: none;">
                        <li><a href="mailto:volunteerportal@gemail.com">Volunteerportal@gemail.com</a></li>
                        <li><a href="tel:+123456789">+123 456 789</a></li>
                        <li>Kigali, Rwanda</li>
                    </div>
                </div>
            </div>

            {{-- aggrement links --}}
            <div class="last mt-3 mb-5 d-flex flex-row justify-content-center">
                <a href="#">User Agreemen</a>
                <a href="#">Privacy Policies</a>
            </div>
        </div>

        <p class="footer">&copy; {{ date('Y') }} Volunteer Portal</p>
    </footer>

    <script src="{{ asset('assets/js/outer.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>

</html>
