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
            <a href="{{ route('cand.home') }}" class="logo">
                <i class='bx'><img src="assets/images/logo.png" alt="" width="45px"></i>
                <div class="logo-name"><span>Vol</span>Portal</div>
            </a>
            <ul class="side-menu">
                <li><a href="{{ route('cand.home') }}"><i class='bx bx-home'></i>Home</a></li>
                <li><a href="{{ route('cand.dashboard') }}"><i class='bx bxs-dashboard'></i>Activities</a></li>
                <li><a href="{{ route('cand.pastevent') }}"><i class='bx bx-analyse'></i>Past Events</a></li>
                <li><a href="{{ route('cand.community') }}"><i class='bx bx-group'></i>Community</a></li>
                {{-- <li><a href="{{ route('cand.support') }}"><i class='bx bx-support'></i>Support</a></li> --}}
                <li class="active"><a href="{{ route('cand.settings') }}"><i class='bx bx-cog'></i>Settings</a></li>
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
                        <h4>Update your profile</h4>

                        <div class="ids d-flex justify-content-around mt-4">
                            <div>
                                <form action="{{ route('user.update-profile', $loggedInUser->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3"
                                        style="position: relative; width: 95px; height: 95px; border-radius: 10%; overflow: hidden;">
                                        @if (session('user.profileimage'))
                                            <img src="{{ asset('storage/' . session('user.profileimage')) }}"
                                                id="profileImage" alt="User Image"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                            <label for="profileimage"
                                                style="position: absolute; top: 30; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; cursor: pointer;">
                                                <i class="bx bxs-camera" style="color: white"></i>
                                            </label>
                                        @else
                                            <p>No profile Image</p>
                                            <label for="profileimage"
                                                style="position: absolute; top: 30; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; cursor: pointer;">
                                                <i class="bx bxs-camera" style="color: #0081CF"></i>
                                            </label>
                                        @endif

                                        <input type="file" id="profileimage" name="profileimage" style="display: none;"
                                            accept="image/*">
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="text" placeholder="First Name" class="form-control"
                                                name="fname" value="{{ $loggedInUser->fname }}">
                                            @error('fname')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" placeholder="Last Name" class="form-control"
                                                name="lname" value="{{ $loggedInUser->lname }}">
                                            @error('lname')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" placeholder="ID/Indangamuntu" class="form-control"
                                            name="rwandan_id" readonly onclick="showEditConfirmation()"
                                            value="{{ $loggedInUser->rwandan_id }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" placeholder="Email" class="form-control" name="email"
                                            value="{{ $loggedInUser->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+250</span>
                                            </div>
                                            <input type="tel" placeholder="Phone" class="form-control"
                                                name="phone_number" value="{{ $loggedInUser->phone_number }}">
                                            @error('phone_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <select id="province" class="form-control" name="province"
                                                onchange="populateDistricts()">
                                                <option value="Kigali City"
                                                    {{ $loggedInUser->province == 'Kigali City' ? 'selected' : '' }}>
                                                    Kigali City</option>
                                                <option value="Eastern Province"
                                                    {{ $loggedInUser->province == 'Eastern Province' ? 'selected' : '' }}>
                                                    Eastern Province</option>
                                                <option value="Southern Province"
                                                    {{ $loggedInUser->province == 'Southern Province' ? 'selected' : '' }}>
                                                    Southern Province</option>
                                                <option value="Western Province"
                                                    {{ $loggedInUser->province == 'Western Province' ? 'selected' : '' }}>
                                                    Western Province</option>
                                                <option value="Northern Province"
                                                    {{ $loggedInUser->province == 'Northern Province' ? 'selected' : '' }}>
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
                                        <input type="skills" placeholder="skills" class="form-control" name="skills"
                                            value="{{ $loggedInUser->skills }}">
                                        @error('skills')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group mt-4">
                                        <button type="submit"
                                            class="btn btn-primary btn-block font-weight-bold">Update</button>
                                    </div>
                                </form>

                                <div class="form-group mt-4">
                                    <a href="#" data-toggle="modal" data-target="#updatePasswordModal">
                                        <button type="button" class="btn btn-primary btn-block font-weight-bold">Update
                                            Password</button>
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
                                                    action="{{ route('user.update-password', $loggedInUser->id) }}">
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


                                <div class="form-group mt-4">
                                    <a href="#" data-toggle="modal"
                                        data-target="#deleteAccountModal{{ $loggedInUser->id }}"
                                        class="btn btn-danger font-weight-bold">
                                        Delete Account
                                    </a>

                                    <div class="modal fade" id="deleteAccountModal{{ $loggedInUser->id }}"
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
                                                    <form method="POST" action="{{ route('user.delete-account') }}"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" id="userId" name="userId"
                                                            value="{{ $loggedInUser->id }}">
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

            // Add an event listener to the province input field to call the populateDistricts function when the province changes
            const provinceInput = document.getElementById('province');
            provinceInput.addEventListener('change', populateDistricts);

            // Initially populate the districts based on the default selected province (if any)
            populateDistricts();

            function showEditConfirmation() {
                const confirmation = confirm("To change your National ID, please contact Admin.");
                // if (confirmation) {
                //     // You can redirect the user to a contact support page or take other actions here.
                // }
            }

            @if (session('error') || session('success'))
                Swal.fire({
                    icon: '{{ session('error') ? 'error' : 'success' }}',
                    title: '{{ session('error') ? session('error') : session('success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 7000,
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
