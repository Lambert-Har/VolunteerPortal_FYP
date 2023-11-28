@extends('layouts.outer')

@section('title', 'SignUp')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vol-signup.css') }}">

@section('content')

    <body>
        <div class="container">
            <h4 class="text-center mb-5 mt-5">Recruiter Registration</h4>

            <div class="row m-5 no-gutters justify-content-center">
                <div class="col-md-6  p-5 no-gutters shadow-lg" style="background-color: #CCCCCC; border-radius: 10px">
                    <h3 class="pb-3">Sign Up</h3>
                    <form action="{{ route('user.org-signup') }}" method="POST" enctype="multipart/form-data"
                        autocomplete="on">
                        @csrf
                        <div class="form-group">
                            <input id="name" type="text" placeholder="Company Full Name(+accronym)"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+250</span>
                                </div>
                                <input id="phone_number" type="tel" placeholder="Phone"
                                    class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                    value="{{ old('phone_number') }}">
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input id="email" name="email" type="email" placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="category" type="text" placeholder="Category (Ex: Technology)"
                                class="form-control" name="category" value="{{ old('category') }}" autocomplete="category"
                                autofocus>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <select id="province" name="province" class="form-control" onchange="populateDistricts()">
                                    <option value="Kigali City">Kigali City</option>
                                    <option value="Eastern Province">Eastern Province</option>
                                    <option value="Southern Province">Southern Province</option>
                                    <option value="Western Province">Western Province</option>
                                    <option value="Northern Province">Northern Province</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <select id="district" name="district" class="form-control">
                                    <!-- District options will be populated dynamically using JavaScript -->
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <input id="website" name="website" type="url" placeholder="Website Link"
                                class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}"
                                autocomplete="website" autofocus>
                        </div>
                        <div class="form-group">
                            <input id="mission" type="text" name="mission" placeholder="Mission Statement"
                                class="form-control" value="{{ old('mission') }}" autocomplete="mission" autofocus>
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" placeholder="Password"
                                class="form-control  @error('password') is-invalid @enderror" name="password"
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control"
                            name="password_confirmation" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="orglogoimage">Profile image</label>
                            <input type="file" id="orglogoimage" name="orglogoimage" class="form-control-file" value="{{ old('orglogoimage') }}">
                            @error('orglogoimage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <input type="hidden" name="status" value="active">
                        <div class="mt-4    ">
                            <input name="" type="checkbox" value="" required/>
                            <span class="pl-2 font-weight-bold">By clicking sign-up, You agree to our
                                Terms & Condition and Privacy Statement</span>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold">Sign Up</button>
                        </div>
                    </form>
                    <div class="pt-4 text-center">
                        Have an account? <a href="{{ route('user.org-login') }}">Login</a>
                    </div>
                </div>
            </div>

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
