<!-- resources/views/welcome.blade.php -->

@extends('layouts.inside')

@section('title', 'Applicants')
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
            <a href="{{ route('org.dashboard') }}" class="logo">
                <i class='bx'><img src="assets/images/logo.png" alt="" width="45px"></i>
                <div class="logo-name"><span>Vol</span>Portal</div>
            </a>
            <ul class="side-menu">
                <li><a href="{{ route('org.dashboard') }}"><i class='bx bxs-dashboard'></i>Activities</a></li>
                <li class="active"><a href="{{ route('org.applicants') }}"><i class='bx bx-analyse'></i>Applicants</a></li>
                <li><a href="{{ route('org.newpost') }}"><i class='bx bx-repost'></i>New Post</a></li>
                <li><a href="{{ route('org.community') }}"><i class='bx bx-group'></i>Community</a></li>
                {{-- <li><a href="{{ route('org.support') }}"><i class='bx bx-support'></i>Support</a></li> --}}
                <li><a href="{{ route('org.settings') }}"><i class='bx bx-cog'></i>Settings</a></li>
            </ul>
            <ul class="side-menu">
                <li>
                    <a href="{{ route('user.org-logout') }}" class="logout">
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
                        <h5>All Applicants</h5>
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
                <p class="mt-3 text-small">{{ ucwords(session('organization.name')) }}</p>
                <a href="#" class="profile">
                    @if (session('organization.orglogoimage'))
                        <img src="{{ asset('storage/' . session('organization.orglogoimage')) }}">
                    @else
                        <i class="fa-solid fa-user"></i>
                    @endif
                </a>
            </nav>
            <!-- End of vavbar -->

            <!-- body -->
            <main>
                <div class="bottom-data">
                    {{-- Accepted/Upcomin --}}
                    <div class="orders">
                        <div class="header">
                            <h3>On waiting applicants</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Names</th>
                                    <th>Contact</th>
                                    <th>District</th>
                                    <th>Event</th>
                                    <th>Place</th>
                                    <th>Application date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rowNumber = 1;
                                @endphp
                                @if ($applications->isEmpty() || $applications->where('status', 'pending')->isEmpty())
                                    <tr>
                                        <td colspan="8">No data found</td>
                                    </tr>
                                @else
                                    @foreach ($applications as $application)
                                        @if ($application->status === 'pending')
                                            <tr>
                                                <td style="padding-right: 10px">{{ $rowNumber++ }}</td>
                                                <td>{{ $application->user->fname }} {{ $application->user->lname }}</td>
                                                <td>{{ $application->user->phone_number }}</td>
                                                <td>{{ $application->user->district }}</td>
                                                <td>{{ $application->opportunity->title }}</td>
                                                <td>{{ $application->opportunity->district }}</td>
                                                <td>{{ $application->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#viewProfileModal{{ $application->user->id }}"><button
                                                        class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#acceptModal{{ $application->id }}"><button
                                                        class="btn btn-success btn-sm">
                                                        <i class='bx bx-check bx-xs bx-tada-hover'></i>
                                                    </button></a>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#declineModal{{ $application->id }}"><button
                                                        class="btn btn-danger btn-sm">
                                                        <i class='bx bx-x bx-xs bx-burst-hover'></i>
                                                    </button></a>

                                                    {{-- Decline --}}
                                                    <div class="modal fade" id="declineModal{{ $application->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="declineModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="declineModal">Reject
                                                                        application</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to reject <strong
                                                                        id="applicantName">{{ ucwords($application->user->lname) }}</strong>'s
                                                                    application on <strong>{{ $application->opportunity->title }}</strong> event ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <form method="POST"
                                                                        action="{{ route('application.reject') }}"
                                                                        style="display: inline;">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" id="applicationId"
                                                                            name="applicationId"
                                                                            value="{{ $application->id }}">
                                                                        <button type="submit" class="btn btn-danger">Yes,
                                                                            Reject</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Accept --}}
                                                    <div class="modal fade" id="acceptModal{{ $application->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="acceptModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="acceptModal">Accept
                                                                        application</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to accept <br> <strong
                                                                        id="applicantName">{{ ucwords($application->user->lname) }}</strong>'s
                                                                    application onon <strong>{{ $application->opportunity->title }}</strong> event?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <form method="POST"
                                                                        action="{{ route('application.accept') }}"
                                                                        style="display: inline;">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" id="applicationId"
                                                                            name="applicationId"
                                                                            value="{{ $application->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Yes,
                                                                            Accept</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- View profile --}}
                                                    <div class="modal fade" style="z-index: 9999;"
                                                        id="viewProfileModal{{ $application->user->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="viewProfileModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" style="color: #0081CF"
                                                                        id="viewProfileModalLabel">
                                                                        Applicant Profile</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @php
                                                                        // Extract the birth year from the ID
                                                                        $id = $application->user->rwandan_id;
                                                                        $birthYear = substr($id, 1, 4);

                                                                        // Calculate the current year and user's age
                                                                        $currentYear = now()->year;
                                                                        $age = $currentYear - (int) $birthYear;
                                                                    @endphp
                                                                    <div>
                                                                        <div class="image-container">
                                                                            @if ($application->user->profileimage)
                                                                                <img src="{{ asset('storage/' . $application->user->profileimage) }}"
                                                                                    alt="Opportunity Image"
                                                                                    style="width: 100%; max-width: 150px; height: auto;">
                                                                            @else
                                                                                <i class='bx bxs-user'
                                                                                    style="font-size: 120px"></i>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <p><strong>Names:</strong>
                                                                        {{ ucwords($application->user->fname) }}
                                                                        {{ ucwords($application->user->lname) }}
                                                                    </p>
                                                                    <p><strong>Email:</strong>
                                                                        {{ $application->user->email }}</p>
                                                                    <p><strong>Phone:</strong>
                                                                        {{ $application->user->phone_number }}</p>
                                                                    <p><strong>District:</strong>
                                                                        {{ $application->user->province }}</p>
                                                                    <p><strong>Province:</strong>
                                                                        {{ $application->user->district }}</p>
                                                                    <p><strong>Age:</strong> {{ $age }}</p>
                                                                    <p><strong>Skills:</strong>
                                                                        {{ $application->user->skills }}</p>

                                                                    <h5 style="color: #0081CF" class="mt-5">All
                                                                        completed
                                                                        Experiences:</h5>
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            @foreach ($application->user->completedOpportunities as $key => $completedOpportunity)
                                                                                <div class="col-md-6 mb-4">
                                                                                    <div class="card">
                                                                                        @if ($completedOpportunity->logoImage)
                                                                                            <img src="{{ asset('storage/' . $completedOpportunity->logoImage) }}"
                                                                                                class="card-img-top"
                                                                                                alt="Opportunity Image">
                                                                                        @else
                                                                                            <p>No image available for this
                                                                                                opportunity.</p>
                                                                                        @endif
                                                                                        <div class="card-body">
                                                                                            <h5 class="card-title">
                                                                                                {{ $completedOpportunity->title }}
                                                                                            </h5>
                                                                                            <p class="card-text"
                                                                                                style="font-size: 12px">
                                                                                                <strong>Category:</strong>
                                                                                                {{ $completedOpportunity->category }}<br>
                                                                                                <strong>Location:</strong>
                                                                                                {{ $completedOpportunity->province }},
                                                                                                {{ $completedOpportunity->district }}<br>
                                                                                                <strong>Date:</strong>
                                                                                                {{ $completedOpportunity->created_at->format('d-m-Y') }}<br>
                                                                                                <strong>Skills:</strong>
                                                                                                {{ $completedOpportunity->skills }}<br>
                                                                                                <strong>Description:</strong>
                                                                                                {{ $completedOpportunity->description }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @if (($key + 1) % 2 == 0)
                                                                                    {{-- </div> --}}
                                                                                    <!-- Close the current row and start a new one -->
                                                                                    <div class="row">
                                                                                @endif
                                                                            @endforeach
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
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- All --}}
                    <div class="orders">
                        <div class="header">
                            <h3>All Candidates <span class="text-muted"
                                    style="font-size: 12px;">Ongoing/Terminated/Rejected/Canceled/Completed</span></h3>
                        </div>
                        <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Names</th>
                                    <th>Contact</th>
                                    <th>District</th>
                                    <th>Event Name</th>
                                    <th>Event Place</th>
                                    <th>Application date</th>
                                    <th>Event date</th>
                                    <th>Status</th>
                                    {{-- <th>Decision</th> --}}
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
                                            @php
                                                $opportunity = $opportunities->where('id', $application->opportunity_id)->first();
                                            @endphp
                                            @if ($opportunity)
                                                <tr>
                                                    <td>{{ $rowNumber++ }}</td>
                                                    <td>{{ $application->user->fname }} {{ $application->user->lname }}
                                                    </td>
                                                    <td>{{ $application->user->phone_number }}</td>
                                                    <td>{{ $application->user->district }}</td>
                                                    <td>{{ $opportunity->title }}</td>
                                                    <td>{{ $opportunity->district }}</td>
                                                    <td>{{ $application->created_at->format('d-m-Y') }}</td>
                                                    <td>{{ $opportunity->start_time }}</td>
                                                    <td>{{ $application->status }}</td>
                                                    {{-- @if ($application->status == 'ongoing')
                                                        <td>
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#cancelModal{{ $application->user->id }}"><button
                                                                    class="btn btn-danger btn-sm">
                                                                    <i class='bx bx-x-circle bx-xs bx-burst-hover'></i>
                                                                </button></a><br>
                                                            <div class="modal fade"
                                                                id="cancelModal{{ $application->user->id }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="cancelModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="cancelModal">
                                                                                Terminate
                                                                                Caandidate</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to terminate<br>
                                                                            <strong>{{ $application->user->fname }}</strong>
                                                                            from <strong>{{ $opportunity->title }}</strong>
                                                                            ? <br><br>His/Her work will not be considered.
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">No</button>
                                                                            <form method="POST"
                                                                                action="{{ route('application.suspend') }}"
                                                                                style="display: inline;">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <input type="hidden" id="applicationId"
                                                                                    name="applicationId"
                                                                                    value="{{ $application->user->id }}">
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Yes,
                                                                                    Terminate</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <p>N/A</p>
                                                        </td>
                                                    @endif --}}
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach

                                @endif
                            </tbody>
                            <tfoot style="background-color: #dedede; color: black; font-size: 0.2em;">
                                <tr>
                                    <th style="font-size: 12px">No</th>
                                    <th style="font-size: 12px">Names</th>
                                    <th style="font-size: 12px">Contact</th>
                                    <th style="font-size: 12px">District</th>
                                    <th style="font-size: 12px">Event Name</th>
                                    <th style="font-size: 12px">Event Place</th>
                                    <th style="font-size: 12px">Application date</th>
                                    <th style="font-size: 12px">Event date</th>
                                    <th style="font-size: 12px">Status</th>
                                    {{-- <th style="font-size: 12px">Decision</th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </main>
        </div>

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
    </body>
@endsection
