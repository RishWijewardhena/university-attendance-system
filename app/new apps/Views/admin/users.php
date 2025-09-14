<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Manage Users</h2>
            <a href="<?= base_url('/admin/admin_panel') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Back to Admin Panel
            </a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= esc($user['user_id']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= esc($user['user_name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= esc($user['email']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= esc($user['role_id']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <a href="<?= base_url('/admin/users/edit/' . $user['user_id']) ?>" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Edit</a>

                                <?php if ($user['status'] === 'active'): ?>
                                    <a href="<?= base_url('/admin/users/deactivate/' . $user['user_id']) ?>" 
                                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                       onclick="return confirm('Are you sure you want to deactivate this user?')">Deactivate</a>
                                <?php else: ?>
                                    <a href="<?= base_url('/admin/users/activate/' . $user['user_id']) ?>" 
                                       class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded"
                                       onclick="return confirm('Are you sure you want to activate this user?')">Activate</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
