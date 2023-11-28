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
                <li><a href="{{ route('admin.users') }}"><i class='bx bx-group' ></i>All Candidates</a></li>
                <li class="active"><a href="{{ route('admin.organizations') }}"><i class='bx bxs-business'></i></i>All
                        Organizations</a></li>
                <li><a href="{{ route('admin.opportunities') }}"><i class='bx bx-repost'></i>All Posts</a></li>
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
                            <h3>All Organizations <span class="text-muted" style="font-size: 12px;">Active/Passive</span></h3>
                        </div>
                        <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Province</th>
                                    <th>Registration date</th>
                                    <th>Status</th>
                                    <th style="padding-right: 50px">Decision</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rowNumber = 1;
                                @endphp
                                @if ($organizations->isEmpty())
                                    <tr>
                                        <td colspan="8">No data found</td>
                                    </tr>
                                @else
                                    @foreach ($organizations as $organization)
                                        @if ($organization)
                                            <tr>
                                                <td>{{ $rowNumber++ }}</td>
                                                <td style="padding-right: 10px">{{ ucwords($organization->name) }}</td>
                                                <td style="padding-right: 10px">{{ $organization->email }}</td>
                                                <td style="padding-right: 10px">{{ $organization->phone_number }}</td>
                                                <td style="padding-right: 10px">{{ $organization->province }}</td>
                                                <td>
                                                    {{ optional($organization->created_at)->format('d-m-Y') }}</td>
                                                <td style="padding-right: 10px">{{ $organization->status }}</td>
                                                @if ($organization->status == 'active')
                                                <td>

                                                    {{-- Edit --}}
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#editModal{{ $organization->id }}"><button
                                                        class="btn btn-primary btn-sm"><i
                                                            class='bx bx-pencil bx-xs bx-tada-hover'></i></button></a>
                                                    <div class="modal fade" id="editModal{{ $organization->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel">Edit
                                                                        User</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST"
                                                                    action="{{ route('admin.update-organization', $organization->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <input type="name" placeholder="name"
                                                                                class="form-control" name="name"
                                                                                value="{{ $organization->name }}">
                                                                            @error('name')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="email" placeholder="Email"
                                                                                class="form-control" name="email"
                                                                                value="{{ $organization->email }}">
                                                                            @error('email')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span
                                                                                        class="input-group-text">+250</span>
                                                                                </div>
                                                                                <input type="tel" placeholder="Phone"
                                                                                    class="form-control" name="phone_number"
                                                                                    value="{{ $organization->phone_number }}">
                                                                                @error('phone_number')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        {{-- <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <select id="province" class="form-control" name="province"
                                                                                    onchange="populateDistricts()">
                                                                                    <option value="Kigali City"
                                                                                        {{ $user->province == 'Kigali City' ? 'selected' : '' }}>
                                                                                        Kigali City</option>
                                                                                    <option value="Eastern Province"
                                                                                        {{ $user->province == 'Eastern Province' ? 'selected' : '' }}>
                                                                                        Eastern Province</option>
                                                                                    <option value="Southern Province"
                                                                                        {{ $user->province == 'Southern Province' ? 'selected' : '' }}>
                                                                                        Southern Province</option>
                                                                                    <option value="Western Province"
                                                                                        {{ $user->province == 'Western Province' ? 'selected' : '' }}>
                                                                                        Western Province</option>
                                                                                    <option value="Northern Province"
                                                                                        {{ $user->province == 'Northern Province' ? 'selected' : '' }}>
                                                                                        Northern Province</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <select id="district" class="form-control" name="district">
                                                                                    <!-- District options will be populated dynamically using JavaScript -->
                                                                                </select>
                                                                            </div>
                                                                        </div> --}}
                                                                        <div class="form-group">
                                                                            <input type="website" placeholder="website"
                                                                                class="form-control" name="website"
                                                                                value="{{ $organization->website }}">
                                                                            @error('website')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="mission" placeholder="mission"
                                                                                class="form-control" name="mission"
                                                                                value="{{ $organization->mission }}">
                                                                            @error('mission')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save
                                                                            changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Detaild --}}
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#detailsModal{{ $organization->id }}"><button
                                                        class="btn btn-info btn-sm">
                                                        <i class="bx bx-data bx-xs bx-tada-hover"></i>
                                                    </button></a>
                                                    <div class="modal fade" id="detailsModal{{ $organization->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="detailsModalLabel">
                                                                        User Details</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Display user details here -->
                                                                    <h4 style="color: #002E73">
                                                                        {{ ucwords($organization->name) }}</h4>
                                                                    <p><strong>Email: </strong>
                                                                        {{ $organization->email }}</p>
                                                                    <p><strong>Phone: </strong>
                                                                        {{ $organization->phone_number }}</p>
                                                                    <p><strong>Location:</strong>
                                                                        {{ $organization->province }},
                                                                        {{ $organization->district }}
                                                                        District</p>
                                                                    <p><strong>Website: </strong>
                                                                        {{ $organization->website }}</p>
                                                                    <p><strong>Mission: </strong>
                                                                        {{ $organization->mission }}</p>
                                                                    <p><strong>Status: </strong>
                                                                        {{ $organization->status }}</p>
                                                                    <div class="mt-3">
                                                                        <div class="image-container">
                                                                            @if ($organization->orglogoimage)
                                                                                <img src="{{ asset('storage/' . $organization->orglogoimage) }}"
                                                                                    alt="user Image"
                                                                                    style="width: 100%; max-width: 400px; height: auto;">
                                                                            @else
                                                                                <p>No image available for this user.
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

                                                    {{-- Recover --}}
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#editModal{{ $organization->id }}"><button
                                                        class="btn btn-primary btn-sm"><i
                                                            class='bx bx-refresh bx-xs bx-spin-hover'></i></button></a>
                                                    <div class="modal fade" id="editModal{{ $organization->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel">Recover
                                                                        user account
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST"
                                                                    action="{{ route('admin.recover-organization', $organization->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <p>Are you sure, you want to recover
                                                                            <strong>{{ ucwords($organization->name) }}</strong>'s
                                                                            account?
                                                                        </p>
                                                                        <input type="hidden" name="organizationId"
                                                                            id="organizationId"
                                                                            value="{{ $organization->id }}">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">No</button>
                                                                        <button type="submit"
                                                                            class="btn btn-warning">Yes, Recover
                                                                            Account</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Detaild --}}
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#detailsModal{{ $organization->id }}"><button
                                                        class="btn btn-info btn-sm">
                                                        <i class="bx bx-data bx-xs bx-tada-hover"></i>
                                                    </button></a>
                                                    <div class="modal fade" id="detailsModal{{ $organization->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="detailsModalLabel">
                                                                        User Information</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Display user details here -->
                                                                    <h3 style="color: #002E73">
                                                                        {{ ucwords($organization->name) }}
                                                                    </h3>
                                                                    <p><strong>Email: </strong>
                                                                        {{ $organization->email }}</p>
                                                                    <p><strong>Phone: </strong>
                                                                        {{ $organization->phone_number }}</p>
                                                                    <p><strong>Location:</strong>
                                                                        {{ $organization->province }},
                                                                        {{ $organization->district }}
                                                                        District</p>
                                                                    <p><strong>Website: </strong>
                                                                        {{ $organization->website }}</p>
                                                                    <p><strong>Mission: </strong>
                                                                        {{ $organization->mission }}</p>
                                                                    <p><strong>Status: </strong>
                                                                        {{ $organization->status }}</p>
                                                                    <div class="mt-3">
                                                                        <div class="image-container">
                                                                            @if ($organization->orglogoimage)
                                                                                <img src="{{ asset('storage/' . $organization->orglogoimage) }}"
                                                                                    alt="user Image"
                                                                                    style="width: 100%; max-width: 400px; height: auto;">
                                                                            @else
                                                                                <p>No image available for this user.
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
                                                        data-target="#deleteModal{{ $organization->id }}"><button
                                                        class="btn btn-danger btn-sm">
                                                        <i class="bx bx-trash bx-xs bx-tada-hover"></i>
                                                    </button></a>
                                                    <div class="modal fade" id="deleteModal{{ $organization->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel">Delete
                                                                        User Account</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST"
                                                                    action="{{ route('admin.delete-organization', $organization->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="modal-body">
                                                                        <p><strong><i class="bx bx-alert">⚠️</i>This action
                                                                                can't be undone</strong><br>plus all user
                                                                            related data will be deleted permanently</p>
                                                                        <p>Are you sure you want to delete
                                                                            <strong>{{ ucwords($organization->name) }}</strong>'s
                                                                            account?
                                                                        </p>
                                                                        <input type="hidden" name="organizationId"
                                                                            id="organizationId"
                                                                            value="{{ $organization->id }}">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">No</button>
                                                                        <button type="submit" class="btn btn-danger">Yes,
                                                                            Delete Account</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot style="background-color: #dedede; color: black; font-size: 0.2em;">
                                <tr>
                                    <th style="font-size: 12px">No</th>
                                    <th style="font-size: 12px">Name</th>
                                    <th style="font-size: 12px">Email</th>
                                    <th style="font-size: 12px">Phone</th>
                                    <th style="font-size: 12px">Province</th>
                                    <th style="font-size: 12px">Registration Date</th>
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
            // function populateDistricts() {
            //     const provinceInput = document.getElementById('province');
            //     const selectedProvince = provinceInput.value;
            //     const districtsByProvince = {
            //         'Kigali City': ['Gasabo', 'Kicukiro', 'Nyarugenge'],
            //         'Eastern Province': ['Bugesera', 'Gatsibo', 'Kayonza', 'Kirehe', 'Ngoma', 'Nyagatare', 'Rwamagana'],
            //         'Southern Province': ['Gisagara', 'Huye', 'Kamonyi', 'Muhanga', 'Nyamagabe', 'Nyanza', 'Nyaruguru',
            //             'Ruhango'
            //         ],
            //         'Western Province': ['Karongi', 'Ngororero', 'Nyabihu', 'Nyamasheke', 'Rubavu', 'Rusizi', 'Rutsiro'],
            //         'Northern Province': ['Burera', 'Gakenke', 'Gicumbi', 'Musanze', 'Rulindo'],
            //     };
            //     const districtInput = document.getElementById('district');
            //     districtInput.innerHTML = '';
            //     districtsByProvince[selectedProvince].forEach((district) => {
            //         const option = document.createElement('option');
            //         option.value = district;
            //         option.textContent = district;
            //         districtInput.appendChild(option);
            //     });
            // }
            // const provinceInput = document.getElementById('province');
            // provinceInput.addEventListener('change', populateDistricts);
            // populateDistricts();

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
