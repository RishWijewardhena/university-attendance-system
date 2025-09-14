<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center text-indigo-700 mb-6">Lecturer Course Data</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <?php if (!empty($lecturer_courses)): ?>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="px-4 py-2">Lecturer Email</th>
                        <th class="px-4 py-2">Course Code</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lecturer_courses as $course): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-2 text-gray-700"><?= esc($course['lecturer_email']); ?></td>
                            <td class="px-4 py-2 text-gray-700"><?= esc($course['course_code']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-600 text-center mt-4">No data available.</p>
        <?php endif; ?>
    </div>

    <div class="mt-6 flex justify-center">
        <a href="<?= base_url('dashboard'); ?>" class="btn-primary flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
        </a>
    </div>
</div>

<?= $this->endSection() ?>
