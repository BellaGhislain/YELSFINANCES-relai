<x-login-layouts>
    <div class="position-fixed top-0 end-0 start-0 bg-img-start" style="height: 32rem; background-image: url(./assets/svg/components/card-6.svg);">
        <!-- Shape -->
        <div class="shape shape-bottom zi-1">
            <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1921 273">
                <polygon fill="#fff" points="0,273 1921,273 1921,0 "/>
            </svg>
        </div>
        <!-- End Shape -->
    </div>

    <!-- Content -->
    <div class="container position-relative zi-2 d-flex align-items-center min-vh-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <!-- Card -->
                <div class="card card-lg mb-5">
                    <div class="card-body">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Form -->
                        <form class="js-validate needs-validation" novalidate method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="text-center">
                                <div class="mb-5">
                                    <div class="mb-4">
                                        <img src="assets/img/logo.jpeg" alt="YEL'S FINANCES Logo" style="height: 80px; width: auto; border-radius: 10px;">
                                    </div>
                                    <h1 class="display-5 text-warning fw-bold">YEL'S FINANCES</h1>
                                    <p class="text-muted">Centre de Formation</p>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label class="form-label" for="email">{{ __('Email') }}</label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" id="email" placeholder="admin@formation.com" aria-label="admin@formation.com" value="{{ old('email') }}" required autofocus autocomplete="username">
                                <x-input-error :messages="$errors->get('email')" class="invalid-feedback mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label" for="password">{{ __('Mot de passe') }}</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" id="password" placeholder="8+ caractères requis" aria-label="8+ caractères requis" required minlength="8" autocomplete="current-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Afficher/Masquer le mot de passe">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="invalid-feedback mt-2" />
                            </div>

                            <!-- Submit Button and Register Link -->
                            <div class="d-grid mb-4">
                                <x-primary-button class="btn btn-warning btn-lg">
                                    {{ __('Se connecter') }}
                                </x-primary-button>
                            </div>

                            @if (Route::has('register'))
                                <div class="text-center">
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                                        {{ __("Vous n'avez pas de compte ?") }}
                                    </a>
                                </div>
                            @endif
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->

    <!-- JavaScript for Toggle Password and Validation -->
    @push('scripts')
        <script>
            // Toggle Password Visibility
            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordInput = document.getElementById('password');
                const icon = this.querySelector('i');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            });

            // Bootstrap Validation
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.querySelector('.needs-validation');
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        </script>
    @endpush
</x-login-layouts>
