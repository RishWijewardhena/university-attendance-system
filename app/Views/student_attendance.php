<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<!-- Add JavaScript for handling tabs and collapsible sections -->
<script>
function switchTab(subjectCode) {
    // Hide all content sections
    document.querySelectorAll('.subject-content').forEach(section => {
        section.classList.add('hidden');
    });

    // Show selected content section
    document.getElementById(`content-${subjectCode}`).classList.remove('hidden');

    // Update active tab styling
    document.querySelectorAll('.subject-tab').forEach(tab => {
        tab.classList.remove('bg-indigo-600', 'text-white');
        tab.classList.add('bg-white', 'text-gray-700');
    });

    document.getElementById(`tab-${subjectCode}`).classList.remove('bg-white', 'text-gray-700');
    document.getElementById(`tab-${subjectCode}`).classList.add('bg-indigo-600', 'text-white');
}


function toggleCollapse(subjectCode) {
    const content = document.getElementById(`collapse-${subjectCode}`);
    const icon = document.getElementById(`icon-${subjectCode}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        content.classList.add('hidden');
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}

</script>

<div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Attendance Records</h2>
        <p class="mt-2 text-gray-600">View your class attendance history</p>
    </div>

    <?php if (empty($attendance)): ?>
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <i class="fas fa-calendar-times text-gray-400 text-5xl mb-4"></i>
            <p class="text-gray-600 text-lg">No attendance records found.</p>
            <p class="text-gray-500 mt-2">Records will appear here once you start attending classes.</p>
        </div>
    <?php else: ?>
        <?php
        $groupedAttendance = [];
        foreach ($attendance as $record) {
            $groupedAttendance[$record['subject_code']][] = $record;
        }
        ?>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Subjects</p>
                        <p class="text-2xl font-semibold"><?= count($groupedAttendance) ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Classes Attended</p>
                        <p class="text-2xl font-semibold"><?= count($attendance) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subject Tabs Navigation -->
        <div class="mb-6 overflow-x-auto">
            <div class="flex space-x-2 border-b border-gray-200">
                <?php $first = true; ?>
                <?php foreach ($groupedAttendance as $subjectCode => $records): ?>
                    <button id="tab-<?= esc($subjectCode) ?>"
                            onclick="switchTab('<?= esc($subjectCode) ?>')"
                            class="subject-tab px-4 py-2 rounded-t-lg font-medium transition-colors duration-200 <?= $first ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' ?>">
                        <?= esc($subjectCode) ?>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?= $first ? 'bg-white text-indigo-600' : 'bg-gray-100' ?>">
                            <?= count($records) ?>
                        </span>
                    </button>
                    <?php $first = false; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Subject Content Sections -->
        <?php $first = true; ?>
        <?php foreach ($groupedAttendance as $subjectCode => $records): ?>
            <div id="content-<?= esc($subjectCode) ?>" 
                 class="subject-content <?= $first ? '' : 'hidden' ?>">
                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Subject Header with Collapse Toggle -->
                    <div class="p-6 border-b border-gray-200">
                        <button onclick="toggleCollapse('<?= esc($subjectCode) ?>')"
                                class="w-full flex items-center justify-between focus:outline-none">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    <?= esc($subjectCode) ?>
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Classes Attended: <?= count($records) ?>
                                </p>
                            </div>
                            <i id="icon-<?= esc($subjectCode) ?>" 
                               class="fas fa-chevron-up text-gray-400"></i>
                        </button>
                    </div>

                    <!-- Collapsible Content -->
                    <div id="collapse-<?= esc($subjectCode) ?>" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Venue</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($records as $index => $record): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= $index + 1 ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?= esc(date('F j, Y', strtotime($record['attended_at']))) ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?= esc(date('h:i A', strtotime($record['attended_at']))) ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                                <span class="text-sm text-gray-900"><?= esc($record['venue']) ?></span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php $first = false; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Back to Dashboard Button -->
    <div class="mt-8 mb-6">
        <a href="<?= base_url('/dashboard') ?>" 
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Dashboard
        </a>
    </div>
</div>
<?= $this->endSection() ?>