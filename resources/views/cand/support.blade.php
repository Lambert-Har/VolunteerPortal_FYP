<!-- resources/views/welcome.blade.php -->

@extends('layouts.inside')

@section('title', 'Support')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/insidecand/home.css') }}">
<style>
    .sidebar a {
        text-decoration: none;
        color: inherit;
    }

    .sidebar a:hover {
        text-decoration: none;
    }
</style>
@section('content')

    <body>
        <!-- sidebar -->
        <div class="sidebar">
            <a href="{{ route('cand.home') }}" class="logo">
                <i class='bx'><img src="assets/images/logo.png" alt="" width="45px"></i>
                <div class="logo-name"><span>Vol</span>Portal</div>
            </a>
            <ul class="side-menu">
                <li><a href="{{ route('cand.home') }}"><i class='bx bx-home'></i>Home</a></li>
                <li><a href="{{ route('cand.dashboard') }}"><i class='bx bxs-dashboard'></i>Activities</a></li>
                <li><a href="{{ route('cand.pastevent') }}"><i class='bx bx-analyse'></i>Past Events</a></li>
                <li><a href="{{ route('cand.community') }}"><i class='bx bx-group'></i>Community</a></li>
                {{-- <li class="active"><a href="{{ route('cand.support') }}"><i class='bx bx-support'></i>Support</a></li> --}}
                <li><a href="{{ route('cand.settings') }}"><i class='bx bx-cog'></i>Settings</a></li>
            </ul>
            <ul class="side-menu">
                <li>
                    <a href="{{ route('user.vol-logout') }}" class="logout">
                        <i class='bx bx-log-out-circle'></i>
                        Logout
                    </a>  
                </li>
            </ul>
        </div>
        <!-- End of sidebar -->

        <!-- Main Content -->
        <div class="content">
            <!-- Navbar -->
            <nav>
                <i class='bx bx-menu'></i>
                <form action="#">
                    <div class="form-input">
                        <input type="search" placeholder="Search...">
                        <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                    </div>
                </form>
                <input type="checkbox" id="theme-toggle" hidden>
                <label for="theme-toggle" class="theme-toggle"></label>
                {{-- <a href="#" class="notif">
                    <i class='bx bx-bell'></i>
                    <span class="count">12</span>
                </a> --}}
                <p class="mt-3 text-small">{{ ucwords(session('user.fname')) }} {{ ucwords(session('user.lname')) }}</p>
                <a href="#" class="profile">
                    @if (session('user.profileimage'))
                        <img src="{{ asset('storage/' . session('user.profileimage')) }}">
                    @else
                    <i class='bx bx-user'></i>
                    @endif
                </a>
            </nav>
            <!-- End of vavbar -->

            <!-- body -->
            <main>
                <div class="bottom-data">
                    <div class="orders text-center">
                        <h4>Request support</h4>

                        <div class="mb-3">

                            <div class="ids d-flex justify-content-around mt-4">
                                <div>
                                    <form>
                                        <div class="form-group">
                                            <input type="email" placeholder="Email/phone" class="form-control">
                                        </div>
                                        <textarea type="text" class="form-control"></textarea>
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary btn-block font-weight-bold">send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
@endsection
