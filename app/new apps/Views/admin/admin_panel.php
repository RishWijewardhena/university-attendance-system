<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Welcome to the Admin Panel</h2>
        <p class="text-gray-600 mb-8">Manage users, courses, and permissions easily.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Manage Users -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <div class="text-center">
                    <h5 class="text-xl font-bold mb-3">Manage Users</h5>
                    <p class="text-gray-600 mb-4">View, edit, and delete users</p>
                    <a href="<?= base_url('/admin/users') ?>" 
                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Go to Users
                    </a>
                </div>
            </div>

            <!-- Manage Courses -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <div class="text-center">
                    <h5 class="text-xl font-bold mb-3">Manage Courses</h5>
                    <p class="text-gray-600 mb-4">View, add, and update courses</p>
                    <a href="<?= base_url('/admin/courses') ?>" 
                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Go to Courses
                    </a>
                </div>
            </div>
            <!-- Assign Lecturers -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <div class="text-center">
                    <h5 class="text-xl font-bold mb-3">Assign Lecturers</h5>
                    <p class="text-gray-600 mb-4">Assign lecturers to courses</p>
                    <a href="<?= base_url('/admin/assign-lecturers') ?>" 
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Go to Assign Lecturers
                    </a>
                </div>
            </div>


            <!-- Manage Permissions -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <div class="text-center">
                    <h5 class="text-xl font-bold mb-3">Manage Permissions</h5>
                    <p class="text-gray-600 mb-4">Assign roles and permissions</p>
                    <a href="<?= base_url('/admin/permissions') ?>" 
                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Go to Permissions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>