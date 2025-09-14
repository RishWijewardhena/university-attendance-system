<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
<nav class="fixed top-0 w-full z-50 bg-indigo-700/90 backdrop-blur-md shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="#" class="text-white font-bold text-xl flex items-center space-x-2">
                <i class="fas fa-user-check text-lg"></i>
                <span>Attendance System</span>
            </a>
            <div class="hidden md:flex space-x-6">
                <a href="#about" class="text-gray-200 hover:text-white text-sm font-medium transition-colors">About Us</a>
                <a href="#features" class="text-gray-200 hover:text-white text-sm font-medium transition-colors">Features</a>
                <a href="#contact" class="text-gray-200 hover:text-white text-sm font-medium transition-colors">Contact</a>
            </div>
        </div>
    </div>
</nav>


    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="<?= base_url('images/logos/home.jpg') ?>" class="w-full h-full object-cover" alt="Background">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6">
                Student Attendance System
            </h1>
            <p class="text-xl sm:text-2xl text-gray-200 mb-8">
                A Modern Solution for Attendance Management
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/login" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-700 transform hover:-translate-y-1 transition-all duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </a>
                <a href="/register" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-indigo-600 bg-white hover:bg-gray-100 transform hover:-translate-y-1 transition-all duration-200">
                    <i class="fas fa-user-plus mr-2"></i> Register
                </a>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-8">About Us</h2>
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-xl text-gray-600 leading-relaxed">
                    The Student Attendance System is an innovative platform designed to make attendance tracking seamless 
                    and efficient for educational institutions. Using modern technology, we help schools and universities 
                    manage their attendance processes effectively.
                </p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl shadow-lg p-8 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-qrcode text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Barcode Scanning</h3>
                    <p class="text-gray-600">Quick and accurate attendance tracking using advanced barcode technology. Streamline your attendance process with just a scan.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-xl shadow-lg p-8 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-chart-line text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Real-time Analytics</h3>
                    <p class="text-gray-600">Get comprehensive insights and reports on attendance patterns. Make data-driven decisions with our powerful analytics tools.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-xl shadow-lg p-8 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-users text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">User Management</h3>
                    <p class="text-gray-600">Easily manage students and faculty members. Flexible user roles and permissions for efficient administration.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">Contact Us</h2>
            <div class="bg-indigo-50 rounded-xl p-8 max-w-3xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="text-center">
                        <div class="text-indigo-600 mb-4">
                            <i class="fas fa-envelope text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Email Us</h3>
                        <p class="text-gray-600">rishwijewardana@gmail.com</p>
                    </div>
                    <div class="text-center">
                        <div class="text-indigo-600 mb-4">
                            <i class="fas fa-phone text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Call Us</h3>
                        <p class="text-gray-600"> +94 0712250556 </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>