<?php 
    $session = session();
    $role_id = $session->get('role_id'); //  Get logged-in user role

    //  Determine the correct progress page
    $progressPage = ($role_id == 100 || $role_id == 95) ? base_url('admin/progress') : '/progress';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Page Title') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col"> <!--  Ensures Footer stays at bottom -->

    <!--  Fixed Header -->
    <header class="fixed w-full top-0 z-50 bg-gradient-to-r from-indigo-600 to-indigo-800 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center py-4 px-4 sm:px-6 lg:px-8">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    <span class="text-white text-xl font-bold">Attendance system</span>
                </div>

                <!--  Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="<?= base_url('/dashboard') ?>" 
                        class="group flex items-center text-gray-100 hover:text-white transition-colors">
                        <i class="fas fa-home mr-2"></i> 
                        <span class="relative">
                            Dashboard
                            <?php if (current_url() == base_url('/dashboard')): ?>
                                <span class="absolute -bottom-2 left-0 w-full h-0.5 bg-white rounded-full"></span>
                            <?php endif; ?>
                        </span>
                    </a>
                    
                    <?php if (hasPermission('show_progress')): ?>
                        <a href="<?= $progressPage ?>" 
                            class="group flex items-center text-gray-100 hover:text-white transition-colors">
                            <i class="fas fa-chart-line mr-2"></i> 
                            <span class="relative">
                                Progress
                                <?php if (current_url() == $progressPage): ?>
                                    <span class="absolute -bottom-2 left-0 w-full h-0.5 bg-white rounded-full"></span>
                                <?php endif; ?>
                            </span>
                        </a>
                    <?php endif; ?>

                    <?php if (hasPermission('show_admin_panel')): ?>
                        <a href="<?= base_url('/admin/admin_panel') ?>" 
                            class="group flex items-center text-gray-100 hover:text-white transition-colors">
                            <i class="fas fa-user-shield mr-2"></i> 
                            <span class="relative">
                                Admin Panel
                                <?php if (current_url() == base_url('/admin/admin_panel')): ?>
                                    <span class="absolute -bottom-2 left-0 w-full h-0.5 bg-white rounded-full"></span>
                                <?php endif; ?>
                            </span>
                        </a>
                    <?php endif; ?>
                </nav>

                <!-- User Profile/Logout -->
                <div class="relative group">
                    <button class="flex items-center space-x-3 text-gray-100 hover:text-white focus:outline-none">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($session->get('user_name') ?? 'Guest') ?>&background=random" 
                            alt="Profile" class="h-8 w-8 rounded-full">
                        <span><?= esc($session->get('user_name') ?? 'Guest') ?></span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <a href="<?= base_url('/profile') ?>" 
                            class="block px-4 py-2 text-gray-800 hover:bg-indigo-50">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <hr class="my-2">
                        <a href="<?= base_url('/logout') ?>" 
                            class="block px-4 py-2 text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!--  Main Content -->
    <main class="flex-grow mt-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        <?= $this->renderSection('content') ?>
    </main>

    <!--  Footer -->
    <footer class="bg-gradient-to-r from-indigo-800 to-indigo-900 text-white py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>© <?= date('Y') ?> Learning Dashboard. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
