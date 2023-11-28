@extends('layouts.inside')

@section('title', 'Past Events')
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
                <li class="active"><a href="{{ route('cand.pastevent') }}"><i class='bx bx-analyse'></i>Past Events</a></li>
                <li><a href="{{ route('cand.community') }}"><i class='bx bx-group'></i>Community</a></li>
                {{-- <li><a href="{{ route('cand.support') }}"><i class='bx bx-support'></i>Support</a></li> --}}
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
                        <h5>Completed Activities</h5>
                        {{-- <input type="search" placeholder="Search...">
                        <button class="search-btn" type="submit"><i class='bx bx-search'></i></button> --}}
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
            @php
                use Carbon\Carbon;
            @endphp

            <main>
                <div class="bottom-data">
                    @if (count($opportunities) > 0)
                    @foreach ($opportunities as $opportunity)
                        <div class="orders">
                            <div class=" mb-3 d-flex justify-content-between">
                                <div class="ids d-flex justify-content-start">
                                    <div
                                        style="width: 55px; height: 55px; border-radius: 50%; overflow: hidden; margin-right: 6px;">
                                        <img src="assets/images/orgimages/orglogo/orglogo.jpg" alt=""
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <a href="#">
                                            <h5 class="mb-0 text-dark">{{ $opportunity->organization->name }}</h5>
                                        </a>
                                        <p class="text-muted small mb-0" style="font-size: 12px">
                                            {{ $opportunity->organization->category }}</p>
                                        <p class="text-muted small" style="font-size: 12px">
                                            {{ $opportunity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <i class="fas fa-ellipsis-h"></i>
                            </div>

                            <div class="post">
                                {{-- <p style="font-weight: 600">{{ $opportunity->title }}</p> --}}
                                <div style="font-size: 15px; margin-left: 14px">
                                    <p class="mb-1">Category: {{ $opportunity->category }}</p>
                                    <p class="mb-1">Location: {{ $opportunity->province }}, {{ $opportunity->district }}
                                    </p>
                                    <p class="mb-2">Date:
                                        {{ Carbon::parse($opportunity->start_time)->format('F d, Y, h:i A') }} -
                                        {{ Carbon::parse($opportunity->end_time)->format('F d, Y, h:i A') }}</p>
                                    <p class="mb-3" style="font-weight: 500">Deadline: August 28, 2023</p>

                                    <div class="description"
                                        style="overflow: hidden; max-height: 66px; transition: max-height 0.3s ease-in-out;">
                                        <p class="mb-2"><strong>Description:<br></strong>{{ $opportunity->description }}</p>
                                    </div>
                                    <button class="readMoreButton mb-3" style="border: none; color: blue; display: none;"
                                        onclick="toggleDescription(this)">Read More...</button>

                                    <a href="#"><button
                                            style="border-radius: 2px;margin-top: 12px;width: 120px;padding: 5px; color:white;border: none;background-color: #d21932">Event Completed</button></a>

                                    <div class="mt-3">
                                        <div class="image-container">
                                            @if ($opportunity->logoImage)
                                                <img src="{{ asset('storage/' . $opportunity->logoImage) }}"
                                                    alt="Opportunity Image"
                                                    style="width: 100%; max-width: 400px; height: auto;">
                                            @else
                                                <p>No image available for this opportunity.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                    <p>There haven't been any past events as of now.</p>
                @endif
                </div>
            </main>
        </div>

        <script>
            function toggleDescription(button) {
                var description = button.previousElementSibling;

                if (description.style.maxHeight) {
                    description.style.maxHeight = null;
                    button.innerHTML = 'Read Less';
                } else {
                    description.style.maxHeight = '66px';
                    button.innerHTML = 'Read More...';
                }
            }

            var buttons = document.querySelectorAll('.readMoreButton'); 
            buttons.forEach(function(button) {
                var description = button.previousElementSibling;
                if (description.scrollHeight > 60) {
                    button.style.display = 'block';
                }
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success', // You can use 'success' or 'error' for the appearance
                    title: '{{ session('success') }}',
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
