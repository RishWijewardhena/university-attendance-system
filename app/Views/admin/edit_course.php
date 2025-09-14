<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Edit Course</h2>
            <a href="<?= base_url('/admin/courses') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Back to Courses
            </a>
        </div>

        <form action="<?= base_url('/admin/courses/update/' . $course['course_id']) ?>" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Course Name</label>
                <input type="text" name="course_name" value="<?= $course['course_name'] ?>" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Course Code</label>
                <input type="text" name="course_code" value="<?= $course['course_code'] ?>" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Update Course
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>