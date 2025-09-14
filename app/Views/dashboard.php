<?= $this->extend('layouts/main_layout') ?>

<?php $this->setVar('title', 'Dashboard'); ?>

<?= $this->section('content') ?>
<div class="container mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">

    <!-- Left Side (Main Content) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Stats Overview -->
        <?php if (session('role_id') != 50): // Student ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="stats-card p-5 rounded-xl shadow-md bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Active Courses</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            <?= count($courses) ?>
                        </h3>
                    </div>

                    <div class="bg-indigo-100 p-3 rounded-full">
                        <i class="fas fa-book text-indigo-600"></i>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>


        <!-- Success Message -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <!-- Error Message -->
        <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
        <?php endif; ?>

         <!-- Courses Section for Students -->
            <?php if (session('role_id') == 50): // Student ?>
                <div class="card p-6 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-xl shadow-lg">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-calendar-check text-indigo-600 mr-2"></i> View Attendance
                    </h2>
                    
                    <div class="text-center">
                        <a href="<?= base_url('attendance/student') ?>" 
                            class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white text-lg font-semibold rounded-full shadow-md 
                                hover:bg-indigo-700 hover:scale-105 transform transition-all duration-200 ease-in-out
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            
                            <!-- New SVG: Calendar with Checkmark (Attendance) -->
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" 
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M8 2v2m8-2v2m-9 4h10M3 8h18M5 10v10a2 2 0 002 2h10a2 2 0 002-2V10M9 15l2 2 4-4">
                                </path>
                            </svg>
                            View Attendance
                        </a>
                    </div>
                </div>
            <?php endif; ?>



        <!-- Lecturer Courses Section -->
        <?php if (session('role_id') != 50): // Lecturer ?>
            <div class="card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Your Courses</h2>

                    <?php if (hasPermission('create_class')): ?>
                        <button 
                            onclick="window.location.href='<?= base_url('/create-class') ?>'" 
                            class="px-4 py-2 rounded-lg flex items-center space-x-2 
                            <?= empty($courses) ? 'bg-gray-400 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700' ?> text-white" 
                            <?= empty($courses) ? 'disabled' : '' ?>>
                            <i class="fas fa-plus"></i>
                            <span>Create Class</span>
                        </button>
                    <?php endif; ?>

                </div>

                <?php if (empty($courses)): ?>
                    <div class="text-center py-8">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-book-open text-4xl"></i>
                        </div>
                        <p class="text-gray-500">You are not assigned to any courses. Contact Admin and assign courses</p>
                    </div>
                    <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        <?php foreach ($courses as $course): ?>
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow transform hover:-translate-y-1">
                <a href="<?= base_url('course/' . urlencode($course['course_code'])) ?>" 
                   class="block p-6">
                    <!-- Course Icon -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                            <i class="fas fa-book-open text-xl"></i> <!-- Course Icon -->
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </div>

                    <!-- Course Details -->
                    <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($course['course_code']) ?></h3>
                    <p class="text-gray-600"><?= htmlspecialchars($course['course_name']) ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

            </div>
        <?php endif; ?>
    </div>

    <!-- Right Side (Calendar) -->
    <div class="lg:col-span-1 self-start">
        <div class="card p-6 bg-white rounded-xl shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Calendar</h2>
            <div class="calendar-container">
                <div class="flex justify-between items-center mb-4">
                    <button id="prevMonth" class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <h3 id="monthYear" class="text-lg font-semibold"></h3>
                    <button id="nextMonth" class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <div id="calendarGrid" class="grid grid-cols-7 gap-2 text-center text-gray-800">
                    <!-- Calendar days will be inserted dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript for the Calendar
    const calendarGrid = document.getElementById('calendarGrid');
    const monthYear = document.getElementById('monthYear');
    const currentDate = new Date();

    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const today = new Date();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        calendarGrid.innerHTML = '';
        monthYear.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

        // Add day names
        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        dayNames.forEach((day) => {
            calendarGrid.innerHTML += `<div class="font-bold text-gray-500 uppercase">${day}</div>`;
        });

        // Fill blanks for days before the start of the month
        for (let i = 0; i < firstDay; i++) {
            calendarGrid.innerHTML += '<div></div>';
        }

        /// Populate calendar with days
        for (let day = 1; day <= daysInMonth; day++) {
            let dayDiv = document.createElement('div');
            dayDiv.classList.add(
                'flex', 'items-center', 'justify-center', 'w-10', 'h-10', 
                'rounded-full', 'cursor-pointer', 'transition-all', 
                'text-gray-800', 'hover:bg-indigo-200'
            );

            if (
                today.getFullYear() === year &&
                today.getMonth() === month &&
                today.getDate() === day
            ) {
                dayDiv.classList.add('bg-indigo-600', 'text-white', 'font-bold');
            }

            dayDiv.textContent = day;
            calendarGrid.appendChild(dayDiv);
        }

    }

    // Render initial calendar
    renderCalendar(currentDate);

    // Navigation buttons
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });
</script>

<?= $this->endSection() ?>
