<!-- resources/views/welcome.blade.php -->

@extends('layouts.inside')

@section('title', 'Settings')
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
                <li><a href="{{ route('org.dashboard') }}"><i class='bx bxs-dashboard'></i>Activities</a></li>
                <li><a href="{{ route('org.applicants') }}"><i class='bx bx-analyse'></i>Applicants</a></li>
                <li><a href="{{ route('org.newpost') }}"><i class='bx bx-repost'></i>New Post</a></li>
                <li><a href="{{ route('org.community') }}"><i class='bx bx-group'></i>Community</a></li>
                {{-- <li><a href="{{ route('org.support') }}"><i class='bx bx-support'></i>Support</a></li> --}}
                <li class="active"><a href="{{ route('org.settings') }}"><i class='bx bx-cog'></i>Settings</a></li>
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
                    <h5>Customize Profile</h5>
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
                    <div class="orders text-center">
                        <h4>Update your profile</h4>

                        <div class="mb-3">

                            <div class="ids d-flex justify-content-around mt-4">
                                <div>
                                    <form action="{{ route('org.update-profile', $loggedInOrg->id) }}" method="POST"
                                        enctype="multipart/form-data" autocomplete="on">
                                        @csrf
                                        <div class="mb-3"
                                            style="position: relative; width: 95px; height: 95px; border-radius: 10%; overflow: hidden;">
                                            @if (session('organization.orglogoimage'))
                                                <img src="{{ asset('storage/' . session('organization.orglogoimage')) }}"
                                                    id="orglogoimage-preview" alt="organization Image"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                <label for="orglogoimage"
                                                    style="position: absolute; top: 30; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; cursor: pointer;">
                                                    <i class="bx bxs-camera" style="color: white"></i>
                                                </label>
                                            @else
                                                <p>No profile Image</p>
                                                <label for="orglogoimage"
                                                    style="position: absolute; top: 30; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; cursor: pointer;">
                                                    <i class="bx bxs-camera" style="color: #0081CF"></i>
                                                </label>
                                            @endif

                                            <input type="file" id="orglogoimage" name="orglogoimage"
                                                style="display: none;" accept="image/*">
                                        </div>


                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $loggedInOrg->name }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+250</span>
                                                </div>
                                                <input type="tel" placeholder="Phone" class="form-control"
                                                    name="phone_number" value="{{ $loggedInOrg->phone_number }}">
                                                @error('phone_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" placeholder="Email" class="form-control" name="email"
                                                value="{{ $loggedInOrg->email }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="text" placeholder="Company Type(Ex: Technology)"
                                                class="form-control" name="category"
                                                value="{{ $loggedInOrg->category }}">
                                            @error('category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <select id="province" class="form-control" name="province"
                                                    onchange="populateDistricts()">
                                                    <option value="Kigali City"
                                                        {{ $loggedInOrg->province == 'Kigali City' ? 'selected' : '' }}>
                                                        Kigali City</option>
                                                    <option value="Eastern Province"
                                                        {{ $loggedInOrg->province == 'Eastern Province' ? 'selected' : '' }}>
                                                        Eastern Province</option>
                                                    <option value="Southern Province"
                                                        {{ $loggedInOrg->province == 'Southern Province' ? 'selected' : '' }}>
                                                        Southern Province</option>
                                                    <option value="Western Province"
                                                        {{ $loggedInOrg->province == 'Western Province' ? 'selected' : '' }}>
                                                        Western Province</option>
                                                    <option value="Northern Province"
                                                        {{ $loggedInOrg->province == 'Northern Province' ? 'selected' : '' }}>
                                                        Northern Province</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <select id="district" class="form-control" name="district">
                                                    <!-- District options will be populated dynamically using JavaScript -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="url" placeholder="Website Link" class="form-control"
                                                name="website" value="{{ $loggedInOrg->website }}">
                                            @error('website')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="text" placeholder="Mission Statement" class="form-control"
                                                name="mission" value="{{ $loggedInOrg->mission }}">
                                            @error('mission')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-4">
                                            <button type="submit"
                                                class="btn btn-primary btn-block font-weight-bold">Update</button>
                                        </div>
                                    </form>

                                    {{-- pass update --}}
                                    <div class="form-group mt-4">
                                        <a href="#" data-toggle="modal" data-target="#updatePasswordModal">
                                            <button type="button"
                                                class="btn btn-primary btn-block font-weight-bold">Update Password</button>
                                        </a>
                                    </div>
                                    <div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog"
                                        aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updatePasswordModalLabel">Update Password
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST"
                                                        action="{{ route('org.update-password', $loggedInOrg->id) }}">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="oldpass">Old Password</label>
                                                            <input type="password" class="form-control" id="oldpass"
                                                                name="oldpass" required>
                                                            @error('oldpass')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="newpass">New Password</label>
                                                            <input type="password" class="form-control" id="newpass"
                                                                name="newpass" required>
                                                            @error('newpass')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="confirm">Confirm Password</label>
                                                            <input type="password" class="form-control" id="confirm"
                                                                name="newpass_confirmation" required>
                                                            @error('confirm')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Update
                                                            Password</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- acc delete --}}
                                    <div class="form-group mt-4">
                                        <a href="#" data-toggle="modal"
                                            data-target="#deleteAccountModal{{ $loggedInOrg->id }}"
                                            class="btn btn-danger font-weight-bold">
                                            Delete Account
                                        </a>
    
                                        <div class="modal fade" id="deleteAccountModal{{ $loggedInOrg->id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteAccountModal">Delete Account
                                                            Confirmation</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete your account?<br>
                                                        <strong>You'll have only 15 days to recover it</strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form method="POST" action="{{ route('org.delete-account') }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" id="organisationId" name="organisationId"
                                                                value="{{ $loggedInOrg->id }}">
                                                            <button type="submit" class="btn btn-danger">Yes,
                                                                Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                    </div>
                                </div>
                            </div>
                        </div>
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

            const provinceInput = document.getElementById('province');
            provinceInput.addEventListener('change', populateDistricts);

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
