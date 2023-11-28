<!-- resources/views/welcome.blade.php -->

@extends('layouts.inside')

@section('title', 'Community')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/insidecand/home.css') }}">
<style>
    .sidebar a {
        text-decoration: none;
        color: inherit;
    }

    .sidebar a:hover {
        text-decoration: none;
    }

    .message-container {
        max-height: 350px;
        overflow-y: auto;
        padding-right: 20px;
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
                <li class="active"><a href="{{ route('cand.community') }}"><i class='bx bx-group'></i>Community</a></li>
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
                        <h5>Community Forum</h5>
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
            <main>
                <div id="scroll-container" class="bottom-data "
                    style="max-height: 520px; overflow-y: auto; margin-top: -45px">
                    <div class="orders">
                        @foreach ($allPosts as $post)
                            <div class="message-container">
                                <div class=" mb-3 ">
                                    <div class="ids d-flex justify-content-start mb-3">
                                        <div
                                            style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; margin-right: 6px;">
                                            @if ($post->user && $post->user->profileimage)
                                                <img src="{{ asset('storage/' . $post->user->profileimage) }}"
                                                    alt="User Image" style="width: 100%; height: 100%; object-fit: cover;">
                                            @elseif ($post->organization && $post->organization->orglogoimage)
                                                <img src="{{ asset('storage/' . $post->organization->orglogoimage) }}"
                                                    alt="Organization Image"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <i class='bx bxs-user'
                                                    style="font-size: 40px; line-height: 40px; width: 100%; height: 100%;color: #002E73"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="#">
                                                <h5 class="mb-0 text-dark">
                                                    {{ $post->user ? ucwords($post->user->fname) . ' ' . ucwords($post->user->lname) : ($post->organization ? ucwords($post->organization->name) : 'Unknown') }}
                                                </h5>
                                            </a>
                                            <span class="text-muted small" style="font-size: 12px">
                                                {{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-5 mt-1" style="margin-left: 38px" style="font-size: 15px;position: inherit;">
                                            {{ $post->content }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <form action="{{ route('community.post') }}" method="POST">
                            @csrf
                            <div class="message-input">
                                <div class="d-flex justify-content-between">
                                    <input type="text" name="content" placeholder="Type your message..."
                                        class="form-control" value="{{ old('content') }}">
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-send"></i></button>
                                </div>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var scrollContainer = document.getElementById("scroll-container");
                scrollContainer.scrollTop = scrollContainer.scrollHeight;
            });

            @if (session('error') || session('success'))
                Swal.fire({
                    icon: '{{ session('error') ? 'error' : 'success' }}',
                    title: '{{ session('error') ? session('error') : session('success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
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
