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
                <li class="active"><a href="{{ route('org.newpost') }}"><i class='bx bx-repost'></i>New Post</a></li>
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
                        <h5>Deliver Actiity</h5>
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
                        <h4>Post new opportunity</h4>

                        <div class="ids d-flex justify-content-around mt-4">
                            <div>
                                <form action="{{ route('org.newpost') }}" method="post" enctype="multipart/form-data"
                                    autocomplete="on">
                                    @csrf
                                    <div class="form-group">
                                        <input name="title" type="text" placeholder="Tittle" class="form-control"
                                            value="{{ old('title') }}">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <textarea name="description" type="text" placeholder="Description" class="form-control"
                                            value="{{ old('description') }}"></textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="category" type="text" placeholder="Category(Ex: Technology)"
                                            class="form-control" value="{{ old('category') }}">
                                        @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="start_time" type="datetime-local" placeholder="Start Time"
                                            class="form-control" value="{{ old('start_time') }}">
                                        @error('start_time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="end_time" type="datetime-local" placeholder="End Time"
                                            class="form-control" value="{{ old('end_time') }}">
                                        @error('end_time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <select name="province" id="province" class="form-control"
                                                onchange="populateDistricts()" value="{{ old('province') }}">
                                                <option value="Kigali City">Kigali City</option>
                                                <option value="Eastern Province">Eastern Province</option>
                                                <option value="Southern Province">Southern Province</option>
                                                <option value="Western Province">Western Province</option>
                                                <option value="Northern Province">Northern Province</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <select name="district" id="district" class="form-control" value="{{ old('district') }}">
                                                <!-- District options will be populated dynamically using JavaScript -->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <textarea name="skills" type="text" placeholder="Required skills" class="form-control" value="{{ old('skills') }}"></textarea>
                                        @error('skills')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="vol_number" type="text" placeholder="Number of Volunteer"
                                            class="form-control" value="{{ old('vol_number') }}">
                                        @error('vol_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="age" type="text" placeholder="Age(Ex: Between 20-30)"
                                            class="form-control" value="{{ old('age') }}">
                                        @error('age')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <textarea name="benefit" type="text" placeholder="Volunteer benefits" class="form-control" value="{{ old('benefit') }}"></textarea>
                                        @error('benefit')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="logoImage">Related image/if any</label>
                                        <input type="file" id="logoImage" name="logoImage" class="form-control-file" value="{{ old('logoImage') }}">
                                        @error('logoImage')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="status" value="ongoing">
                                    <input type="hidden" name="organization_id" value="{{ $organizationId }}">
                                    <div class="form-group mt-4">
                                        <button type="submit"
                                            class="btn btn-primary btn-block font-weight-bold">Submit</button>
                                    </div>
                                </form>
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
