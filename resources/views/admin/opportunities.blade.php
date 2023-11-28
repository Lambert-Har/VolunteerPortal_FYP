<!-- resources/views/welcome.blade.php -->

@extends('layouts.inside')

@section('title', 'All Organizations')
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
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <i class='bx'><img src="assets/images/logo.png" alt="" width="45px"></i>
                <div class="logo-name"><span>Vol</span>Portal</div>
            </a>
            <ul class="side-menu">
                <li><a href="{{ route('admin.users') }}"><i class='bx bx-group'></i>All Candidates</a></li>
                <li><a href="{{ route('admin.organizations') }}"><i class='bx bxs-business'></i></i>All
                        Organizations</a></li>
                <li class="active"><a href="{{ route('admin.opportunities') }}"><i class='bx bx-repost'></i>All Posts</a>
                </li>
                {{-- <li><a href="{{ route('admin.support') }}"><i class='bx bx-support'></i>Support</a></li> --}}
                {{-- <li><a href="{{ route('admin.settings') }}"><i class='bx bx-cog'></i>Settings</a></li> --}}
            </ul>
            <ul class="side-menu">
                <li>
                    <a href="{{ route('admin.logout') }}" class="logout">
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
                        <h5>ADMIN</h5>
                        {{-- <input type="search" placeholder="Search...">
                        <button class="search-btn" type="submit"><i class='bx bx-search'></i></button> --}}
                    </div>
                </form>
                <input type="checkbox" id="theme-toggle" hidden>
                <label for="theme-toggle" class="theme-toggle"></label>
                <p class="mt-3 text-small"><strong>Admin.</strong>{{ ucwords(session('admin.name')) }}</p>
            </nav>
            <!-- End of vavbar -->

            <!-- body -->
            <main>
                <div class="bottom-data">
                    <div class="orders">
                        <div class="header">
                            <h3>Ongoing Activities <span class="text-muted" style="font-size: 12px;">Ongoing/Canceled/Completed</span></h3>
                        </div>
                        <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Organization Name</th>
                                    <th>Event</th>
                                    <th>Location</th>
                                    <th>Date Posted</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rowNumber = 1;
                                @endphp
                                @if ($opportunities->isEmpty())
                                    <tr>
                                        <td colspan="8">No data found</td>
                                    </tr>
                                @else
                                    @foreach ($opportunities as $opportunity)
                                        @if ($opportunity)
                                            <tr>
                                                <td>{{ $rowNumber++ }}</td>
                                                <td>{{ ucwords($opportunity->organization->name) }}</td>
                                                <td>{{ $opportunity->title }}</td>
                                                <td>{{ $opportunity->district }}</td>
                                                <td style="padding-right: 10px">
                                                    {{ optional($opportunity->created_at)->format('d-m-Y') }}</td>
                                                <td>{{ $opportunity->status }}</td>
                                                <td>
                                                    {{-- Detaild --}}
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#detailsModal{{ $opportunity->id }}"><button
                                                        class="btn btn-info btn-sm">
                                                        <i class="bx bx-data bx-xs bx-tada-hover"></i>
                                                    </button></a>
                                                    <div class="modal fade" id="detailsModal{{ $opportunity->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="detailsModalLabel">
                                                                        Opportunity Details</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Display user details here -->
                                                                    <h4 style="color: #002E73">
                                                                        {{ ucwords($opportunity->organization->name) }}
                                                                    </h4>

                                                                    <P><strong>Title:
                                                                        </strong>{{ $opportunity->title }}
                                                                    </P>
                                                                    <p><strong>Description:
                                                                        </strong>{{ $opportunity->description }}</p>
                                                                    <p><strong>Category:</strong>
                                                                        {{ $opportunity->category }}</p>
                                                                    <p><strong>Start Time:</strong>
                                                                        {{ $opportunity->start_time }}</p>
                                                                    <p><strong>End Time:</strong>
                                                                        {{ $opportunity->end_time }}</p>
                                                                    <p><strong>Place:</strong>
                                                                        {{ $opportunity->province, $opportunity->district }}
                                                                        District
                                                                    </p>
                                                                    <p><strong>Skills:</strong>
                                                                        {{ $opportunity->skills }}</p>
                                                                    <p><strong>Number:</strong>
                                                                        {{ $opportunity->vol_number }}</p>
                                                                    <p><strong>Age:</strong>
                                                                        {{ $opportunity->age }}</p>
                                                                    <p><strong>Benefits:</strong>
                                                                        {{ $opportunity->benefit }}</p>
                                                                    <div class="mt-3">
                                                                        <div class="image-container">
                                                                            @if ($opportunity->logoImage)
                                                                                <img src="{{ asset('storage/' . $opportunity->logoImage) }}"
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

                                                    {{-- Delete --}}
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#deleteModal{{ $opportunity->id }}"><button
                                                        class="btn btn-danger btn-sm">
                                                        <i class="bx bx-trash bx-xs bx-tada-hover"></i>
                                                    </button></a>
                                                    <div class="modal fade" id="deleteModal{{ $opportunity->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel">Delete
                                                                        posted event</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST"
                                                                    action="{{ route('admin.delete-opportunity', $opportunity->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="modal-body">
                                                                        <p><strong><i class="bx bx-alert">⚠️</i>This
                                                                                action
                                                                                can't be undone</strong><br>plus all
                                                                            related data will be deleted permanently
                                                                            which
                                                                            can make candidates loose their aquired
                                                                            experience from their profiles</p>
                                                                        <p>Are you sure you want to delete
                                                                            <strong>{{ ucwords($opportunity->title) }}</strong>
                                                                            event?
                                                                        </p>
                                                                        <input type="hidden" name="opportunityId"
                                                                            id="opportunityId"
                                                                            value="{{ $opportunity->id }}">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">No</button>
                                                                        <button type="submit" class="btn btn-danger">Yes,
                                                                            Delete Event</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot style="background-color: #dedede; color: black; font-size: 0.2em;">
                                <tr>
                                    <th style="font-size: 12px">No</th>
                                    <th style="font-size: 12px">Organization Name</th>
                                    <th style="font-size: 12px">Event</th>
                                    <th style="font-size: 12px">Location</th>
                                    <th style="font-size: 12px">Date Posted</th>
                                    <th style="font-size: 12px">Status</th>
                                    <th style="font-size: 12px">Decision</th>
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
