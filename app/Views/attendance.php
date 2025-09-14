<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container mx-auto max-w-4xl">
    <!-- Class Header Section -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-lg shadow-md mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2">
            📌 Attendance for Class Code: <?= esc($classDetails->random_code) ?>
        </h1>
        <p class="mt-2">
            🕒 <strong>Scheduled Time:</strong> <?= esc($classDetails->scheduled_time) ?>
        </p>
        <p class="mt-1">
            📍 <strong>Venue:</strong> <?= esc($classDetails->venue) ?>
        </p>
    </div>

    <!-- Attendance Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 border-b-2 border-indigo-600 pb-2 mb-4">
            📋 Attendance Records
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse shadow-lg">
                <thead>
                    <tr class="bg-indigo-600 text-white text-left">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">🎓 Registration Number</th>
                        <th class="px-4 py-3">📅 Date Attended</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($attendance)): ?>
                        <?php foreach ($attendance as $index => $record): ?>
                            <tr class="<?= $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' ?> hover:bg-gray-200 transition">
                                <td class="px-4 py-3 text-center font-semibold"><?= $index + 1 ?></td>
                                <td class="px-4 py-3 text-center"><?= esc($record->reg_no) ?></td>
                                <td class="px-4 py-3 text-center"><?= esc($record->attended_at) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-600">
                                🚫 No attendance records found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Back Button -->
        <div class="mt-6 text-center">
            <a href="<?= base_url('course/' . urlencode($subject_code)) ?>" 
               class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md shadow-md transition">
                ⬅️ Back to Course
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
