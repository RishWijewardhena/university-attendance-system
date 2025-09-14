<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="pt-20 container mx-auto px-4">
    <div class="max-w-3xl mx-auto">
        
        <!-- Header Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Create New Class</h2>
            <p class="mt-2 text-gray-600">Fill in the details below to create a new class session.</p>
        </div>

        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert success">
                <i class="fas fa-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert error">
                <i class="fas fa-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Main Form -->
        <div class="form-card">
            <form action="<?= base_url('/create-class/store') ?>" method="post" id="createClassForm" class="space-y-8">
                
                <!-- Course Code Field -->
                <div class="form-group">
                    <label for="subject_code">Course Code <span class="required">Required</span></label>
                    <select id="subject_code" name="subject_code" required class="form-input">
                        <option value="">Select a Course Code</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course['course_code'] ?>" data-name="<?= htmlspecialchars($course['course_name'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= $course['course_code'] ?> (<?= htmlspecialchars($course['course_name'], ENT_QUOTES, 'UTF-8') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="course_name_display" class="info-box">
                        <i class="fas fa-info-circle"></i>
                        Course Name: <span id="course_name" class="font-medium">Please select a course</span>
                    </div>
                </div>

                <!-- Scheduled Time Field -->
                <div class="form-group">
                    <label for="scheduled_time">Scheduled Time <span class="required">Required</span></label>
                    <input type="datetime-local" id="scheduled_time" name="scheduled_time" required class="form-input">
                </div>

                <!-- Venue Field -->
                <div class="form-group">
                    <label for="venue_select">Venue <span class="required">Required</span></label>
                    <select id="venue_select" name="venue" class="form-input">
                        <option value="">Select a Venue</option>
                        <?php foreach ($venues as $venue): ?>
                            <option value="<?= $venue['venue'] ?>"><?= $venue['venue'] ?></option>
                        <?php endforeach; ?>
                        <option value="other">Other</option>
                    </select>
                    <input type="text" id="venue_manual" name="venue_manual" class="hidden form-input" placeholder="Enter custom venue">
                </div>

                <!-- Submit Button -->
                <div class="form-actions">
                    <a href="<?= base_url('/dashboard') ?>" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <button type="submit" class="btn-primary">
                        <span>Create Class</span>
                        <div id="submitLoading" class="hidden"><i class="fas fa-circle-notch fa-spin"></i></div>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    $(document).ready(function() {
        // Update Course Name when selecting Course Code
        $('#subject_code').change(function() {
            var selectedOption = $(this).find(':selected');
            var courseName = selectedOption.data('name');

            console.log("Selected Course Code:", selectedOption.val()); // Debugging
            console.log("Course Name:", courseName); // Debugging

            $('#course_name').text(courseName || 'Please select a course');
        });

        // Venue selection handling (show/hide manual entry)
        $('#venue_select').change(function() {
            if ($(this).val() === 'other') {
                $('#venue_manual').removeClass('hidden').attr('required', true).focus();
            } else {
                $('#venue_manual').addClass('hidden').removeAttr('required');
            }
        });

        // Form submission handling (disable button + show loading)
        $('#createClassForm').on('submit', function() {
            $('#submitLoading').removeClass('hidden');
            $('button[type="submit"]').prop('disabled', true);
        });
    });
</script>

<!-- Styles -->
<style>
    .alert {
        padding: 1rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1rem;
    }
    .alert.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
    .alert.error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
    
    .form-card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { font-weight: 500; display: flex; justify-content: space-between; }
    .form-input { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; background: #f9fafb; }
    .info-box { margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280; background: #f9fafb; padding: 0.75rem; border-radius: 8px; }
    .hidden { display: none; }

    .form-actions { display: flex; gap: 1rem; justify-content: space-between; align-items: center; }
    .btn-primary, .btn-secondary {
        padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; text-align: center; display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .btn-primary { background: #4f46e5; color: white; }
    .btn-primary:hover { background: #4338ca; }
    .btn-secondary { background: white; color: #374151; border: 1px solid #d1d5db; }
    .btn-secondary:hover { background: #f3f4f6; }
</style>

<?= $this->endSection() ?>
