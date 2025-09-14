<?= $this->extend('layouts/main_layout') ?>
<?php $this->setVar('title', 'Profile'); ?>

<?= $this->section('content') ?>
<div class="bg-white shadow-xl rounded-lg overflow-hidden max-w-2xl mx-auto mt-8">
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 p-6">
        <h2 class="text-2xl font-bold text-white flex items-center">
            <i class="fas fa-user-circle mr-4"></i>
            User Profile
        </h2>
    </div>
    
    <div class="p-6 space-y-4">
        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-gray-100 rounded-lg p-4 flex items-center">
                <i class="fas fa-id-badge text-indigo-600 text-2xl mr-4"></i>
                <div>
                    <p class="text-gray-600 text-xs">Full Name</p>
                    <p class="text-lg font-semibold text-gray-800">
                        <?= esc($user['user_name']) ?>
                    </p>
                </div>
            </div>
            
            <div class="bg-gray-100 rounded-lg p-4 flex items-center">
                <i class="fas fa-envelope text-green-600 text-2xl mr-4"></i>
                <div>
                    <p class="text-gray-600 text-xs">Email Address</p>
                    <p class="text-lg font-semibold text-gray-800">
                        <?= esc($user['email']) ?>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-100 rounded-lg p-4 flex items-center">
            <i class="fas fa-user-tag text-purple-600 text-2xl mr-4"></i>
            <div>
                <p class="text-gray-600 text-xs">User Role</p>
                <p class="text-lg font-semibold text-gray-800">
                    <?= esc($user['role_name']) ?>
                </p>
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 mt-4">
            <a href="<?= base_url('dashboard') ?>" class="btn bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>