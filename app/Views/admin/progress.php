<?= $this->extend('layouts/main_layout') ?>
<?php $this->setVar('title', 'Progress'); ?>

<?= $this->section('content') ?>

<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">📊 Attendance Progress</h2>

    <!-- Loading State -->
    <div id="loading-message" class="text-center text-gray-500">Loading attendance data...</div>

    <!-- Container for Multiple Charts -->
    <div id="charts-container" class="mt-6 space-y-6"></div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    fetch("<?= base_url('/admin/progress-data') ?>")
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById("charts-container");
            const loadingMessage = document.getElementById("loading-message");
            loadingMessage.style.display = "none"; // Hide loading message

            // ✅ Handle if no attendance data is available
            if (!data.attendance || Object.keys(data.attendance).length === 0) {
                container.innerHTML = "<p class='text-gray-500 text-center'>No attendance data available.</p>";
                return;
            }

            // ✅ Loop through each course and create a chart
            Object.keys(data.attendance).forEach(courseCode => {
                const course = data.attendance[courseCode];
                const courseName = course.course_name;
                const classes = course.classes;

                // Create a container for each course
                const courseDiv = document.createElement("div");
                courseDiv.classList.add("bg-white", "shadow-lg", "p-6", "rounded-lg", "border", "border-gray-200");
                courseDiv.innerHTML = `
                    <h3 class="text-xl font-semibold text-indigo-700 mb-4">${courseName} (${courseCode})</h3>
                    <div class="w-full" style="height: 400px;"> <!-- Increased Height -->
                        <canvas id="chart-${courseCode}"></canvas>
                    </div>
                `;
                container.appendChild(courseDiv);

                // Prepare data for the chart
                const labels = classes.map(item => `Code: ${item.random_code}`);
                const counts = classes.map(item => item.total);

                // ✅ Keep all bars in shades of blue
                const backgroundColors = labels.map(() => 'rgba(54, 162, 235, 0.7)'); // Blue
                const borderColors = labels.map(() => 'rgba(54, 162, 235, 1)'); // Darker Blue

                // Render Chart
                const ctx = document.getElementById(`chart-${courseCode}`).getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: `Attendance Count for ${courseName}`,
                            data: counts,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1,
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // ✅ Allows custom height
                        scales: {
                            y: { 
                                beginAtZero: true,
                                ticks: { stepSize: 1 },
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
                                text: `Attendance Progress for ${courseName}`,
                                font: { size: 16, weight: "bold" },
                                padding: { top: 10, bottom: 20 }
                            }
                        }
                    }
                });
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById("charts-container").innerHTML = "<p class='text-red-500 text-center'>Failed to load attendance data.</p>";
        });
});

</script>

<?= $this->endSection() ?>
