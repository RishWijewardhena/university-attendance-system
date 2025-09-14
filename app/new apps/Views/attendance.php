<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container mx-auto">
    <h1 class="text-2xl font-bold text-indigo-600 mb-6">
        Attendance for Class Code: <?= esc($classDetails->random_code) ?>
    </h1>
    <p class="mb-4"><strong>Scheduled Time:</strong> <?= esc($classDetails->scheduled_time) ?></p>
    <p class="mb-4"><strong>Venue:</strong> <?= esc($classDetails->venue) ?></p>

    <div class="attendance-section">
        <h2 class="text-xl font-semibold border-b-2 border-indigo-600 mb-4">
            Attendance Records
        </h2>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Registration Number</th>
                    <th class="border border-gray-300 px-4 py-2">Date Attended</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($attendance)): ?>
                    <?php foreach ($attendance as $index => $record): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= $index + 1 ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= esc($record->reg_no) ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= esc($record->attended_at) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="border border-gray-300 px-4 py-2 text-center text-gray-600">
                            No attendance records found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="<?= base_url('course/' . urlencode($subject_code)) ?>" class="button bg-indigo-600 text-white px-4 py-2 rounded mt-4 hover:bg-indigo-700">
    Back to Course
</a>


    </div>
</div>
<?= $this->endSection() ?>
