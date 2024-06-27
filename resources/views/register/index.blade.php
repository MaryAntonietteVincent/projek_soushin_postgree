@include('templating.header')

<body class="">
    <style>
        /* Additional styling to make the icon more user-friendly */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
            /* Add spacing between input groups */
        }

        .form-control {
            padding-right: 2.5rem;
            /* Make space for the eye icon */
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2rem;
            /* Adjust the size of the icon */
            color: #6c757d;
            /* Default color for the icon */
        }

        .toggle-password:hover {
            color: #495057;
            /* Darken the icon on hover */
        }
    </style>
    <main class="main-content  mt-0">
        @include('sweetalert::alert')
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                                style="background-image: url('../assets//img/logos/projek.jpg'); background-size: cover;">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                            <div class="card card-plain">
                                <div class="card-header">
                                    <h4 class="font-weight-bolder">Sign Up</h4>
                                    <p class="mb-0">Enter your email and password to register</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" onsubmit="return validateForm()"
                                        action="{{ route('registeract') }}" method="post">
                                        @csrf
                                        <div><span>Nama</span></div>
                                        <div class="input-group input-group-outline mb-3">
                                            {{-- <label class="form-label">Nama</label> --}}
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                        </div>
                                        <div><span>No Telfon</span></div>
                                        <div class="input-group input-group-outline mb-3">
                                            {{-- <label class="form-label">No telfon</label> --}}
                                            <input type="number" class="form-control" name="no_hp" value="{{ old('no_hp') }}">
                                        </div>
                                        <div><span>alamat</span></div>
                                        <div class="input-group input-group-outline mb-3">

                                            <textarea name="alamat" id="" cols="30" rows="10" class="form-control">{{ old('alamat') }}</textarea>
                                        </div>
                                        <div><span>Email</span></div>
                                        <div class="input-group input-group-outline mb-3">
                                            {{-- <label class="form-label">Email</label> --}}
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                        </div>
                                        <div><span>Password</span></div>
                                        <div class="input-group input-group-outline mb-3">
                                            {{-- <label class="form-label">Password</label> --}}
                                            <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                                                id="password-field">
                                            <i class="fas fa-eye toggle-password" id="togglePassword"
                                                onclick="togglePasswordVisibility('password-field', 'togglePassword')"></i>
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" name="confirm_password"
                                                id="confirm-password-field">
                                            <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"
                                                onclick="togglePasswordVisibility('confirm-password-field', 'toggleConfirmPassword')"></i>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign
                                                Up</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-2 text-sm mx-auto">
                                        Punya Akun?
                                        <a href="{{ route('login') }}"
                                            class="text-primary text-gradient font-weight-bold">Sign in</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function togglePasswordVisibility(inputId, toggleId) {
            const passwordField = document.getElementById(inputId);
            const togglePassword = document.getElementById(toggleId);

            // Toggle the type attribute between 'password' and 'text'
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle the eye icon between 'eye' and 'eye-slash'
            togglePassword.classList.toggle('fa-eye');
            togglePassword.classList.toggle('fa-eye-slash');
        }



        function validateForm() {
            // Mengambil nilai dari input password dan konfirmasi password
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            const errorMessage = document.getElementById('error-message');

            // Memeriksa apakah password dan konfirmasi password cocok
            if (password !== confirmPassword) {
                // Menampilkan pesan error jika tidak cocok
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Konfirmasi password tidak cocok!",
                    // footer: '<a href="#">Why do I have this issue?</a>'
                });
                return false; // Mencegah form dikirim
            }

            // Menyembunyikan pesan error jika cocok
            errorMessage.style.display = 'none';
            return true; // Membiarkan form dikirim
        }
    </script>
    @include('templating.footer_js')
