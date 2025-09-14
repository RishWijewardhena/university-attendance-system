<?= $this->extend('layouts/main_layout') ?>

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
            <!-- <div class="stats-card p-5 rounded-xl shadow-md bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Upcoming Tasks</p>
                        <h3 class="text-2xl font-bold text-gray-800">5</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-tasks text-green-600"></i>
                    </div>
                </div>
            </div> -->
            <!-- <div class="stats-card p-5 rounded-xl shadow-md bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Progress</p>
                        <h3 class="text-2xl font-bold text-gray-800">78%</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-chart-line text-blue-600"></i>
                    </div>
                </div>
            </div> -->
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
            
            <div class="card p-6 bg-white rounded-xl shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">View Attendance</h2>
                <div class="space-y-4">               
                <a href="<?= base_url('attendance/student') ?>" 
                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
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
                    <div class="space-y-4">
                        <?php foreach ($courses as $course): ?>
                            <div class="course-card p-4 bg-gray-50 rounded-lg shadow-sm hover:bg-gray-100 transition-all">
                                <a href="<?= base_url('course/' . urlencode($course['course_code'])) ?>"
                                    class="flex justify-between items-center">
                                    <div>
                                        <h3><?= htmlspecialchars($course['course_code']) ?></h3>
                                        <p><?= htmlspecialchars($course['course_name']) ?></p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
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
