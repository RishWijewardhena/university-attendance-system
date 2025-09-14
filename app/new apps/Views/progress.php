<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Attendance Progress</h2>

    <?php if (!empty($attendanceData)) : ?>
        <?php foreach ($attendanceData as $subjectCode => $course) : ?>
            <div class="card bg-white shadow-md p-4 mb-6 rounded-lg">
                <h4 class="text-xl font-bold"><?= htmlspecialchars($course['course_name']) ?> (<?= htmlspecialchars($subjectCode) ?>)</h4>
                <canvas id="chart-<?= str_replace(' ', '_', $subjectCode) ?>" class="mt-4"></canvas>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p class="text-gray-500">No attendance data available.</p>
    <?php endif; ?>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php 
        $courseAttendance = [];

        foreach ($attendanceData as $subjectCode => $course) {
            $subjectCodeJS = str_replace(' ', '_', $subjectCode);

            $courseAttendance[$subjectCodeJS] = [
                'labels' => [], // Class IDs as labels
                'data' => []
            ];

            foreach ($course['classes'] as $class) {
                $courseAttendance[$subjectCodeJS]['labels'][] = $class['class_id'];
                $courseAttendance[$subjectCodeJS]['data'][] = $class['total'];
            }
        }
    ?>

    <?php foreach ($courseAttendance as $subjectCodeJS => $course) : ?>
        const ctx<?= $subjectCodeJS ?> = document.getElementById('chart-<?= $subjectCodeJS ?>').getContext('2d');

        new Chart(ctx<?= $subjectCodeJS ?>, {
            type: 'bar',
            data: {
                labels: <?= json_encode($course['labels']) ?>, 
                datasets: [{
                    label: 'Total Attendance Count per Class',
                    data: <?= json_encode($course['data']) ?>, 
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    <?php endforeach; ?>
</script>

<?= $this->endSection() ?>
