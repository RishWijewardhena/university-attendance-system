<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Edit User</h2>
            <a href="<?= base_url('/admin/users') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Back to Users
            </a>
        </div>

        <?php if (session()->has('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <?= session()->get('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/admin/users/update/' . $user['user_id']) ?>" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">User Name</label>
                <input type="text" 
                       name="name" 
                       value="<?= old('name', $user['user_name']) ?>" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" 
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" 
                       name="email" 
                       value="<?= old('email', $user['email']) ?>" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" 
                       required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                <select name="role" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500">
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role['role_id'] ?>" 
                                <?= (old('role', $user['role_id']) == $role['role_id']) ? 'selected' : '' ?>>
                            <?= esc($role['role_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex space-x-4">
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                    Update User
                </button>
                <a href="<?= base_url('/admin/users') ?>" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>