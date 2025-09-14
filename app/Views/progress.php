<?php $this->extend('layouts/main_layout') ?>
<?php $this->setVar('title', 'Progress'); ?>

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
    // Prepare the attendance data for JavaScript
    $courseAttendance = [];

    foreach ($attendanceData as $subjectCode => $course) {
        $subjectCodeJS = str_replace(' ', '_', $subjectCode);

        $courseAttendance[$subjectCodeJS] = [
            'courseName' => $course['course_name'],
            'labels' => [],
            'data' => []
        ];

        foreach ($course['classes'] as $class) {
            $courseAttendance[$subjectCodeJS]['labels'][] = 'Code: ' . $class['random_code']; // ✅ Use "Code: $random_code" as the label
            $courseAttendance[$subjectCodeJS]['data'][] = $class['total']; // Attendance data
        }
    }
    ?>

    <?php foreach ($courseAttendance as $subjectCodeJS => $course) : ?>
        const ctx<?= $subjectCodeJS ?> = document.getElementById('chart-<?= $subjectCodeJS ?>').getContext('2d');

        new Chart(ctx<?= $subjectCodeJS ?>, {
            type: 'bar',
            data: {
                labels: <?= json_encode($course['labels']) ?>, // Random codes as labels
                datasets: [{
                    label: 'Total Attendance Count per Class',
                    data: <?= json_encode($course['data']) ?>, // Attendance data for each class
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { // ✅ Y-axis Label
                            display: true,
                            text: "Attendance Count",
                            font: { size: 14, weight: "bold" }
                        }
                    },
                    x: {
                        title: { // ✅ X-axis Label
                            display: true,
                            text: "Class Codes",
                            font: { size: 14, weight: "bold" }
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    title: { // ✅ Chart Title
                        display: true,
                        text: "Attendance Progress for <?= htmlspecialchars($course['courseName']) ?>",
                        font: { size: 16, weight: "bold" },
                        padding: { top: 10, bottom: 20 }
                    }
                }
            }
        });
    <?php endforeach; ?>
</script>

<?= $this->endSection() ?>
