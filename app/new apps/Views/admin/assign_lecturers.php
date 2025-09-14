<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Assign Lecturers</h2>

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



        <!-- Add Lecturer Form -->
        <form action="<?= base_url('/admin/assign-lecturers/store') ?>" method="post" class="mb-6">
            <div class="grid grid-cols-3 gap-4">
                <input type="email" name="lecturer_email" placeholder="Lecturer Email" class="border p-2 rounded">
                <input type="text" name="course_code" placeholder="Course Code" class="border p-2 rounded">
                <!-- <input type="number" name="admin_user_id" placeholder="Admin User ID" class="border p-2 rounded"> -->
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Assign</button>
            </div>
        </form>

        <!-- Upload CSV Form -->
        <form action="<?= base_url('/admin/assign-lecturers/uploadCSV') ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" class="border p-2 rounded">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Upload CSV</button>
        </form>

        <!-- Display Assigned Lecturers -->
        <h3 class="text-xl font-bold mt-6">Assigned Lecturers</h3>
        <table class="w-full border-collapse border mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Lecturer Email</th>
                    <th class="border p-2">Course Code</th>
                    <th class="border p-2">Admin User ID</th>
                    <th class="border p-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lecturers as $lecturer): ?>
                <tr>
                    <td class="border p-2"><?= $lecturer['id'] ?></td>
                    <td class="border p-2"><?= $lecturer['lecturer_email'] ?></td>
                    <td class="border p-2"><?= $lecturer['course_code'] ?></td>
                    <td class="border p-2"><?= $lecturer['admin_user_id'] ?></td>
                    <td class="border p-2"><?= $lecturer['created_at'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
