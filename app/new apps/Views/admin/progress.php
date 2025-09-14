<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>

<h2 class="text-2xl font-semibold text-gray-800">Attendance Progress</h2>

<div id="charts-container" class="mt-6"></div> <!-- Container for multiple charts -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("<?= base_url('/admin/progress-data') ?>")
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById("charts-container");

                // ✅ Handle if no attendance data is available
                if (!data.attendance || Object.keys(data.attendance).length === 0) {
                    container.innerHTML = "<p class='text-gray-500'>No attendance data available.</p>";
                    return;
                }

                // ✅ Loop through each course and create a chart
                Object.keys(data.attendance).forEach(courseCode => {
                    const course = data.attendance[courseCode];
                    const courseName = course.course_name;
                    const classes = course.classes;

                    // Create a container for each course
                    const courseDiv = document.createElement("div");
                    courseDiv.classList.add("chart-container", "bg-white", "shadow-md", "p-4", "rounded-lg", "mt-4");
                    courseDiv.innerHTML = `<h3 class="text-lg font-semibold text-indigo-700">${courseName} (${courseCode})</h3>
                                            <canvas id="chart-${courseCode}"></canvas>`;
                    container.appendChild(courseDiv);

                    // Prepare data for the chart
                    const labels = classes.map(item => `Class ${item.class_id}`);
                    const counts = classes.map(item => item.total);

                    // ✅ Generate random colors for each course
                    const backgroundColors = labels.map(() => `rgba(${Math.floor(Math.random() * 255)}, 
                                                                     ${Math.floor(Math.random() * 255)}, 
                                                                     ${Math.floor(Math.random() * 255)}, 0.6)`);
                    const borderColors = backgroundColors.map(color => color.replace("0.6", "1"));

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
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.getElementById("charts-container").innerHTML = "<p class='text-red-500'>Failed to load attendance data.</p>";
            });
    });
</script>

<?= $this->endSection() ?>
