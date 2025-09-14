<?= $this->extend('layouts/main_layout') ?>
<?php $this->setVar('title', 'Manage permissions'); ?>

<?= $this->section('content') ?>
<div class="container mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Manage Role Permissions</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/admin/role-permissions/update') ?>" method="post">
            <!-- Add a wrapper div for horizontal scrolling -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border">Role</th>
                            <?php foreach ($permissions as $permission): ?>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border"><?= esc($permission['permission_name']) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $role): ?>
                            <tr>
                                <td class="px-6 py-3 border"><?= esc($role['role_name']) ?></td>
                                <?php foreach ($permissions as $permission): ?>
                                    <td class="px-6 py-3 border text-center">
                                        <input type="checkbox" name="permissions[<?= $role['role_id'] ?>][]" value="<?= $permission['permission_id'] ?>"
                                               <?= in_array($permission['permission_id'], $rolePermissions[$role['role_id']] ?? []) ? 'checked' : '' ?>>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
