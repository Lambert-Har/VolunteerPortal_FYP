<!-- resources/views/welcome.blade.php -->

@extends('layouts.inside')

@section('title', 'Dashboard')
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
                <li class="active"><a href="{{ route('cand.dashboard') }}"><i class='bx bxs-dashboard'></i>Activities</a>
                </li>
                <li><a href="{{ route('cand.pastevent') }}"><i class='bx bx-analyse'></i>Past Events</a></li>
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
                        <h5>Applications</h5>
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
                <div class="bottom-data">
                    
                    {{-- pennding --}}
                    <div class="orders">
                        <div class="header">
                            <h3>All Your applications <span class="text-muted"
                                style="font-size: 12px;">Ongoing/Rejected/Canceled/Completed</span></h3>
                        </div>
                        <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Company Name</th>
                                    <th>Event Name</th>
                                    <th>Location</th>
                                    <th>Application Date</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Status</th>
                                    <th>Decision</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rowNumber = 1;
                                @endphp
                                @if ($applications->isEmpty())
                                    <tr>
                                        <td colspan="8">No data found</td>
                                    </tr>
                                @else
                                    @foreach ($applications as $application)
                                        @if ($application)
                                            <tr>
                                                <td style="padding-right: 10px">{{ $rowNumber++ }}</td>
                                                <td style="padding-right: 10px">{{ $application->organization->name }}
                                                </td>
                                                <td style="padding-right: 10px">{{ $application->opportunity->title }}
                                                </td>
                                                <td style="padding-right: 10px">{{ $application->opportunity->district }}
                                                </td>
                                                <td style="padding-right: 10px">
                                                    {{ $application->created_at->format('d-m-Y') }}</td>
                                                <td style="padding-right: 10px">
                                                    {{ $application->opportunity->start_time }}
                                                </td>
                                                <td style="padding-right: 10px">{{ $application->opportunity->end_time }}
                                                </td>
                                                <td style="padding-right: 10px">{{ $application->status }}</td>

                                                @if ($application->status == 'ongoing')
                                                    <td>
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#detailsModal{{ $application->id }}"><button
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fas fa-eye"></i></button></a>

                                                        <div class="modal fade" id="detailsModal{{ $application->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="detailsModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="detailsModalLabel">
                                                                            Application Details</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Display opportunity details here -->
                                                                        <h3 style="color: #0081CF" class="mb-3">
                                                                            {{ $application->organization->name }}</h3>
                                                                        <h5>{{ $application->opportunity->title }}</h5>
                                                                        <p>{{ $application->opportunity->description }}</p>
                                                                        <p><strong>Category:</strong>
                                                                            {{ $application->opportunity->category }}</p>
                                                                        <p><strong>Start Time:</strong>
                                                                            {{ $application->opportunity->start_time }}</p>
                                                                        <p><strong>End Time:</strong>
                                                                            {{ $application->opportunity->end_time }}</p>
                                                                        <p><strong>Place:</strong>
                                                                            {{ $application->opportunity->province, $application->opportunity->district }}
                                                                        </p>
                                                                        <p><strong>Skills:</strong>
                                                                            {{ $application->opportunity->skills }}</p>
                                                                        <p><strong>Number:</strong>
                                                                            {{ $application->opportunity->vol_number }}</p>
                                                                        <p><strong>Age:</strong>
                                                                            {{ $application->opportunity->age }}</p>
                                                                        <p><strong>Benefits:</strong>
                                                                            {{ $application->opportunity->benefit }}</p>
                                                                        <div class="mt-3">
                                                                            <div class="image-container">
                                                                                @if ($application->opportunity->logoImage)
                                                                                    <img src="{{ asset('storage/' . $application->opportunity->logoImage) }}"
                                                                                        alt="Opportunity Image"
                                                                                        style="width: 100%; max-width: 400px; height: auto;">
                                                                                @else
                                                                                    <p>No image available for this
                                                                                        opportunity.
                                                                                    </p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer d-flex justify-content-start">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @elseif ($application->status == 'pending')
                                                    <td style="padding-right: 10px">

                                                        {{-- <a href=""> --}}
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#deleteApplicationModal{{ $application->id }}"><i
                                                                class='bx bx-x-circle bx-xs bx-burst-hover'></i></button>
                                                        {{-- </a> --}}

                                                        <div class="modal fade"
                                                            id="deleteApplicationModal{{ $application->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="deleteApplicationModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="deleteApplicationModalLabel">Delete
                                                                            Application
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete your application on
                                                                        <strong>{{ $application->opportunity->title }}</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">No</button>
                                                                        <form method="POST"
                                                                            action="{{ route('user.delete-application') }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <input type="hidden" name="applicationId"
                                                                                value="{{ $application->id }}">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Yes,Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                @else
                                                <td><p>N/A</p></td>
                                                @endif

                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot style="background-color: #dedede; color: black; font-size: 0.2em;">
                                <tr>
                                    <th style="font-size: 12px">No</th>
                                    <th style="font-size: 12px">Company Name</th>
                                    <th style="font-size: 12px">Event Name</th>
                                    <th style="font-size: 12px">Location</th>
                                    <th style="font-size: 12px">Application Date</th>
                                    <th style="font-size: 12px">Start date</th>
                                    <th style="font-size: 12px">End date</th>
                                    <th style="font-size: 12px">Status</th>
                                    <th style="font-size: 12px">Decision</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </body>

    <script>
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
@endsection
