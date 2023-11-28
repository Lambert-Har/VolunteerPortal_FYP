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
            <a href="{{ route('org.dashboard') }}" class="logo">
                <i class='bx'><img src="assets/images/logo.png" alt="" width="45px"></i>
                <div class="logo-name"><span>Vol</span>Portal</div>
            </a>
            <ul class="side-menu">
                <li class="active"><a href="{{ route('org.dashboard') }}"><i class='bx bxs-dashboard'></i>Activities</a>
                </li>
                <li><a href="{{ route('org.applicants') }}"><i class='bx bx-analyse'></i>Applicants</a></li>
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
                        <h5>Manage Activities</h5>
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
                    <!-- Upcoming Events Table -->
                    <div class="orders">
                        <div class="header">
                            <h3>All Events <span class="text-muted" style="font-size: 12px;">Ongoing/Canceled/Completed</span></h3>
                        </div>
                        <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Event Name</th>
                                    <th>Location</th>
                                    <th>No of volunteer</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Status</th>
                                    <th style="padding-right: 100px">Decision</th>
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
                                        @if ($opportunity->status)
                                            @php
                                                $currentTime = now(); // Get the current time
                                                $endTime = \Carbon\Carbon::parse($opportunity->end_time);
                                                $rowClass = $currentTime->gt($endTime) ? 'bg-danger text-light' : ''; // Check if end_time has exceeded
                                            @endphp
                                            <tr>
                                                <td style="padding-right: 10px">{{ $rowNumber++ }}</td>
                                                <td style="padding-right: 10px">{{ $opportunity->title }}</td>
                                                <td style="padding-right: 10px">{{ $opportunity->district }}</td>
                                                <td>{{ $opportunity->vol_number }}</td>
                                                <td style="padding-right: 10px">{{ $opportunity->start_time }}</td>
                                                @if ($opportunity->status == 'ongoing')
                                                <td class="{{ $rowClass }}" style="padding-right: 10px">
                                                    {{ $opportunity->end_time }}</td>
                                                @else
                                                <td style="padding-right: 10px">
                                                    {{ $opportunity->end_time }}</td>
                                                @endif
                                                <td style="padding-right: 10px">{{ $opportunity->status }}</td>

                                                @if ($opportunity->status == 'ongoing')
                                                    <td style="padding-right: 10px">
                                                        {{-- edit --}}
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editModal{{ $opportunity->id }}"><button
                                                            class="btn btn-primary btn-sm"><i
                                                                class='bx bx-pencil bx-xs bx-tada-hover'></i></button></a>
                                                        <div class="modal fade" id="editModal{{ $opportunity->id }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editModalLabel">Edit
                                                                            Opportunity</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form method="POST"
                                                                        action="{{ route('opportunity.update', $opportunity->id) }}"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body">
                                                                            <!-- Opportunity fields to edit -->
                                                                            <div class="form-group">
                                                                                <label for="title">Title</label>
                                                                                <input type="text" name="title"
                                                                                    id="title" class="form-control"
                                                                                    value="{{ $opportunity->title }}">
                                                                                @error('title')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <textarea name="description" type="text" class="form-control" id="description">{{ $opportunity->description }}</textarea>
                                                                                @error('description')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input name="category" id="category"
                                                                                    type="text" class="form-control"
                                                                                    value="{{ $opportunity->category }}">
                                                                                @error('category')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input name="start_time" id="start_time"
                                                                                    type="datetime-local"
                                                                                    class="form-control"
                                                                                    value="{{ $opportunity->start_time }}">
                                                                                @error('start_time')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input name="end_time"
                                                                                    type="datetime-local"
                                                                                    class="form-control"
                                                                                    value="{{ $opportunity->end_time }}">
                                                                                @error('end_time')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <select name="province" id="province"
                                                                                        class="form-control"
                                                                                        onchange="populateDistricts()"
                                                                                        value="">
                                                                                        <option>
                                                                                            {{ $opportunity->province }}
                                                                                        </option>
                                                                                        <option value="Kigali City">Kigali
                                                                                            City
                                                                                        </option>
                                                                                        <option value="Eastern Province">
                                                                                            Eastern Province</option>
                                                                                        <option value="Southern Province">
                                                                                            Southern Province</option>
                                                                                        <option value="Western Province">
                                                                                            Western Province</option>
                                                                                        <option value="Northern Province">
                                                                                            Northern Province</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <select name="district" id="district"
                                                                                        class="form-control">
                                                                                        <!-- District options will be populated dynamically using JavaScript -->
                                                                                        <option>
                                                                                            {{ $opportunity->district }}
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <textarea name="skills" type="text" class="form-control">{{ $opportunity->skills }}</textarea>
                                                                                @error('skills')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input name="vol_number" type="text"
                                                                                    class="form-control"
                                                                                    value="{{ $opportunity->vol_number }}">
                                                                                @error('vol_number')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input name="age" type="text"
                                                                                    class="form-control"
                                                                                    value="{{ $opportunity->age }}">
                                                                                @error('age')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <textarea name="benefit" type="text" class="form-control">{{ $opportunity->benefit }}</textarea>
                                                                                @error('benefit')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                @if ($opportunity->logoImage)
                                                                                    <img src="{{ asset('storage/' . $opportunity->logoImage) }}"
                                                                                        alt="Opportunity Image"
                                                                                        style="max-width: 200px;">
                                                                                @else
                                                                                    <p>No image available</p>
                                                                                @endif

                                                                                <input type="file" id="logoImage"
                                                                                    name="logoImage"
                                                                                    class="form-control-file">
                                                                                @error('logoImage')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Save
                                                                                changes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- cancel --}}
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#cancelModal{{ $opportunity->id }}"><button
                                                            class="btn btn-danger btn-sm">
                                                            <i class='bx bx-x-circle bx-xs bx-burst-hover'></i>
                                                        </button></a>
                                                        <div class="modal fade" id="cancelModal{{ $opportunity->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="cancelModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="cancelModal">Cancel
                                                                            Opportunity</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete event <br> <strong
                                                                            id="opportunityTitle">{{ $opportunity->title }}</strong>
                                                                        ? <br><br>All applications will be droped and You
                                                                        will
                                                                        not be able to undo this action once it is completed
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">No</button>
                                                                        <form method="POST"
                                                                            action="{{ route('opportunity.cancel') }}"
                                                                            style="display: inline;">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" id="opportunityId"
                                                                                name="opportunityId"
                                                                                value="{{ $opportunity->id }}">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Yes,
                                                                                Cancel</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- complete --}} 
                                                        <a href="#" data-toggle="modal" 
                                                            data-target="#completeModal{{ $opportunity->id }}"><button
                                                            class="btn btn-success btn-sm">
                                                            <i class='bx bx-check bx-xs bx-tada-hover'></i>
                                                        </button></a>
                                                        <div class="modal fade" id="completeModal{{ $opportunity->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="completeModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="cancelModal">Complete
                                                                            Opportunity</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to complete event <br> <strong
                                                                            id="opportunityTitle">{{ $opportunity->title }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Not yet</button>
                                                                        <form method="POST"
                                                                            action="{{ route('opportunity.complete') }}"
                                                                            style="display: inline;">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" id="opportunityId"
                                                                                name="opportunityId"
                                                                                value="{{ $opportunity->id }}">
                                                                            <button type="submit"
                                                                                class="btn btn-warning">Yes,
                                                                                Complete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- details --}}
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#detailsModal{{ $opportunity->id }}"><button
                                                            class="btn btn-info btn-sm">
                                                            <i class="bx bx-data bx-xs bx-tada-hover"></i>
                                                        </button></a>
                                                        <div class="modal fade" id="detailsModal{{ $opportunity->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="detailsModalLabel" aria-hidden="true">
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
                                                                        <!-- Display opportunity details here -->
                                                                        <h3 style="color: #002E73">
                                                                            {{ $opportunity->title }}
                                                                        </h3>
                                                                        <p>{{ $opportunity->description }}</p>
                                                                        <p><strong>Category:</strong>
                                                                            {{ $opportunity->category }}</p>
                                                                        <p><strong>Start Time:</strong>
                                                                            {{ $opportunity->start_time }}</p>
                                                                        <p><strong>End Time:</strong>
                                                                            {{ $opportunity->end_time }}</p>
                                                                        <p><strong>Place:</strong>
                                                                            {{ $opportunity->province, $opportunity->district }}
                                                                        </p>
                                                                        <p><strong>Skills:</strong>
                                                                            {{ $opportunity->skills }}
                                                                        </p>
                                                                        <p><strong>Number:</strong>
                                                                            {{ $opportunity->vol_number }}</p>
                                                                        <p><strong>Age:</strong> {{ $opportunity->age }}
                                                                        </p>
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

                                                    </td>
                                                @else
                                                    <td>
                                                        <p>N/A</p>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot style="background-color: #dedede; color: black; font-size: 0.2em;">
                                <th style="font-size: 12px">No</th>
                                <th style="font-size: 12px">Event Name</th>
                                <th style="font-size: 12px">Location</th>
                                <th style="font-size: 12px">No of volunteer</th>
                                <th style="font-size: 12px">Start date</th>
                                <th style="font-size: 12px">End date</th>
                                <th style="font-size: 12px">Status</th>
                                <th style="font-size: 12px">Decision</th>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </main>
        </div>

        <script>
            function populateDistricts() {
                // Get the selected province from the province input field
                const provinceInput = document.getElementById('province');
                const selectedProvince = provinceInput.value;

                // Define a JavaScript object that maps provinces to their corresponding districts
                const districtsByProvince = {
                    'Kigali City': ['Gasabo', 'Kicukiro', 'Nyarugenge'],
                    'Eastern Province': ['Bugesera', 'Gatsibo', 'Kayonza', 'Kirehe', 'Ngoma', 'Nyagatare', 'Rwamagana'],
                    'Southern Province': ['Gisagara', 'Huye', 'Kamonyi', 'Muhanga', 'Nyamagabe', 'Nyanza', 'Nyaruguru',
                        'Ruhango'
                    ],
                    'Western Province': ['Karongi', 'Ngororero', 'Nyabihu', 'Nyamasheke', 'Rubavu', 'Rusizi', 'Rutsiro'],
                    'Northern Province': ['Burera', 'Gakenke', 'Gicumbi', 'Musanze', 'Rulindo'],
                };

                // Get the district input field
                const districtInput = document.getElementById('district');

                // Clear the current options in the district select element
                districtInput.innerHTML = '';

                // Populate the district input with options based on the selected province
                districtsByProvince[selectedProvince].forEach((district) => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    districtInput.appendChild(option);
                });
            }

            // Add an event listener to the province input field to call the populateDistricts function when the province changes
            const provinceInput = document.getElementById('province');
            provinceInput.addEventListener('change', populateDistricts);

            // Initially populate the districts based on the default selected province (if any)
            populateDistricts();

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
