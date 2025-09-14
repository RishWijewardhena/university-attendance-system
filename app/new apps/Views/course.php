<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="border-b border-gray-200 pb-4 mb-4">
            <h1 class="text-2xl font-bold text-indigo-600">
                <?= esc($course->subject_code) ?> - <?= esc($course->course_name) ?>
            </h1>
            <p class="text-gray-600 mt-2">
                <span class="font-semibold">Created By:</span> <?= esc(session()->get('user_name')) ?>
            </p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->has('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                <?= esc(session('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>
        
        <!-- Class Information -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                Class Information
            </h2>
            
            <?php if (!empty($randomCodes)): ?>
                <div class="grid gap-4">
                    <?php foreach ($randomCodes as $randomCode): ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="cursor-pointer random-code-link bg-gray-50 px-4 py-3 flex justify-between items-center hover:bg-gray-100">
                                <div class="flex items-center space-x-2">
                                    <span class="text-indigo-600 font-semibold">Week <?= esc($randomCode->week_number) ?></span>
                                    <span class="text-gray-500">|</span>
                                    <span class="text-gray-700">Code: <?= esc($randomCode->random_code) ?></span>
                                </div>
                                <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <div class="expandable-content hidden">
                                <div class="p-4 space-y-4">
                                    <!-- Class Details -->
                                    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                                        <div>
                                            <p class="text-sm text-gray-600">Scheduled Time</p>
                                            <p class="font-medium"><?= esc($randomCode->scheduled_time) ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Venue</p>
                                            <p class="font-medium"><?= esc($randomCode->venue) ?></p>
                                        </div>
                                    </div>

                                    <!-- CSV File Section -->
                                    <div class="border-t border-gray-200 pt-4">
                                        <h3 class="font-medium text-gray-700 mb-3">Attendance File</h3>
                                        <?php if ($randomCode->csv_id): ?>
                                            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg mb-3">
                                                <div>
                                                    <p class="text-sm font-medium"><?= esc($randomCode->file_name) ?></p>
                                                    <p class="text-xs text-gray-500">Status: <?= $randomCode->is_active ? 'Active' : 'Inactive' ?></p>
                                                </div>
                                                <a href="<?= site_url('course/delete-csv/' . esc($randomCode->csv_id)) ?>" 
                                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">
                                                    Delete File
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500 mb-3">No CSV file uploaded for this class.</p>
                                        <?php endif; ?>

                                        <!-- Upload Form -->
                                        <form action="<?= base_url('/course/upload-csv/' . esc($randomCode->class_id)) ?>" 
                                              method="post" 
                                              enctype="multipart/form-data" 
                                              class="space-y-3">
                                            <?= csrf_field() ?>
                                            <div class="flex items-center space-x-3">
                                                <input type="file" 
                                                       name="csv_file" 
                                                       accept=".csv" 
                                                       class="flex-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                                       required>
                                                <button type="submit" 
                                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                                    Upload
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-3 pt-3 border-t border-gray-200">
                                        <a href="<?= base_url('/course/view-attendance/' . esc($randomCode->random_code)) ?>" 
                                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium flex-1 text-center">
                                            View Attendance
                                        </a>
                                        <?php if (hasPermission('delete_class')): ?>
                                            <a href="<?= base_url('/course/delete-class/' . esc($randomCode->class_id)) ?>" 
                                               onclick="return confirmDelete()"
                                               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium flex-1 text-center">
                                                Delete Class
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <p class="text-gray-600">No class information available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const randomCodeLinks = document.querySelectorAll('.random-code-link');

    randomCodeLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const container = link.closest('.border');
            const content = container.querySelector('.expandable-content');
            const arrow = link.querySelector('svg');
            
            // Toggle content
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        });
    });
});

function confirmDelete() {
    return confirm("Warning: Deleting this class will also delete related attendance logs and comments. Are you sure?");
}
</script>
<?= $this->endSection() ?>