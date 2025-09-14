<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-indigo-50 to-indigo-200">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-md">
        <!-- Logo/Image -->
        <div>
            <img class="mx-auto h-24 w-auto rounded-lg" src="<?= base_url('Images/logos/login.png') ?>" alt="Login Image">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-800">
                Login to Your Account
            </h2>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form class="mt-8 space-y-6" action="<?= base_url('/Auth/authenticate') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="space-y-4">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email Address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg 
                            placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 
                            focus:border-indigo-500 sm:text-sm" placeholder="Enter your email">
                    </div>
                </div>

              <!-- Password Field with Toggle -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg 
                            placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 
                            focus:border-indigo-500 sm:text-sm pr-10" 
                            placeholder="Enter your password">
                        
                        <!-- Toggle Password Button -->
                        <button type="button" onclick="togglePassword()" 
                            class="absolute inset-y-0 right-3 flex items-center px-2 text-gray-600">
                            <i id="eyeIcon" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>



            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border 
                    border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 
                    hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-indigo-500 transition-colors duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt"></i>
                    </span>
                    Sign in
                </button>
            </div>

            <!-- Forgot Password Link -->
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <a href="<?= base_url('auth/forgot_password') ?>" 
                        class="font-medium text-indigo-600 hover:text-indigo-500">
                        Forgot your password?
                    </a>
                </div>
            </div>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Or continue with</span>
            </div>
        </div>

        <!-- Google Login Button -->
        <div class="mt-6">
            <a href="<?= base_url('/googlelogin/login') ?>" 
                class="w-full inline-flex items-center justify-center px-4 py-3 
                rounded-lg shadow-sm text-base font-medium text-gray-700 
                bg-white hover:bg-gray-50 border border-gray-300
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                transition-all duration-200 space-x-3 transform hover:-translate-y-0.5">
                
                <!-- Google Logo -->
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" 
                        fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" 
                        fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" 
                        fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" 
                        fill="#EA4335"/>
                </svg>
                
                <!-- Button Text -->
                <span class="text-gray-700">Continue with Google</span>
            </a>
        </div>
    </div>

    <!-- JavaScript for Toggle Password -->
    <script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.replace('fa-eye', 'fa-eye-slash'); // Change icon
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.replace('fa-eye-slash', 'fa-eye'); // Change back
    }
}
</script>


</body>
</html>
