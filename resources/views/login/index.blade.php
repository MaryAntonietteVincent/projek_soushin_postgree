@include('templating.header')


<body class="bg-gray-200">
<style>
        /* Additional styling to make the icon more user-friendly */
        .input-group {
            position: relative;
        }
        .form-control {
            padding-right: 2.5rem;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            cursor: pointer;
        }
        </style>
    <main class="main-content  mt-0">
        @include('sweetalert::alert')
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" class="text-start" action="{{ route('loginact') }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password-field" name="password">
                                        <i class="fas fa-eye toggle-password" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                                    </div>
                                    

                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Log in
                                            </button>
                                    </div>
                                    <p class="mt-4 text-sm text-center">
                                        Belum Punya Akun?
                                        <a href="{{ route('register') }}"
                                            class="text-primary text-gradient font-weight-bold">Sign up</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-6 my-auto">
                            <div class="copyright text-center text-sm text-white text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart" aria-hidden="true"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold text-white"
                                    target="_blank">Projek Soushin Tim</a>
                                for a better web.
                            </div>
                        </div>
                       
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password-field');
            const togglePassword = document.getElementById('togglePassword');
            
            // Toggle the type attribute between 'password' and 'text'
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
    
            // Toggle the eye icon between 'eye' and 'eye-slash'
            togglePassword.classList.toggle('fa-eye');
            togglePassword.classList.toggle('fa-eye-slash');
        }
    </script>
    @include('templating.footer_js')
