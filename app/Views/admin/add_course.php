<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>

<div class="max-w-lg mx-auto mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold text-gray-800">📚 Add New Course</h2>
            <a href="<?= base_url('/admin/courses') ?>" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-all">
                ← Back
            </a>
        </div>

        <!-- Course Form -->
        <form action="<?= base_url('/admin/courses/create') ?>" method="post" class="space-y-5">
            
            <!-- Course Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Course Name</label>
                <input type="text" name="course_name" 
                       class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring focus:ring-indigo-300 focus:outline-none"
                       placeholder="Enter course name" required>
            </div>

            <!-- Course Code -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Course Code</label>
                <input type="text" name="course_code" 
                       class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring focus:ring-indigo-300 focus:outline-none"
                       placeholder="Enter course code" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow-md transition-all">
                ➕ Add Course
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
