<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hotel Expenses and Staff Designation Charts</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <style>
        .chart-container {
            float: left;
            margin-right: 50px;
        }
    </style>
</head>

<body>
<h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="bi bi-graph-up-arrow fa-2x"></i> Statistics</h3>
    <div class="chart-container">
        <div id="barchart_values" style="width: 410px; height: 400px;"></div>
    </div>

    <div class="chart-container">
        <div id="container" style="width: 410px; height: 400px;"></div>
    </div>

    <?php
    include('config.php');

    // Fetch data from user_table for the bar chart
    $userQuery = "SELECT `Designation`, SUM(`Salary`) AS `TotalSalary` FROM `user_table`";
    $userResult = $con->query($userQuery);

    // Fetch data from complaints table for the bar chart
    $complaintsQuery = "SELECT SUM(`budget`) as totalBudget FROM `complaints`";
    $complaintsResult = $con->query($complaintsQuery);

    // Extract data for Google Bar Chart
    $chartData = [
        ['Type', 'Salary', ['role' => 'style']]
    ];

    while ($row = $userResult->fetch_assoc()) {
        $chartData[] = [$row['Designation'], (int)$row['TotalSalary'], 'silver'];
    }

    while ($row = $complaintsResult->fetch_assoc()) {
        $chartData[] = ['Maintenance', (int)$row['totalBudget'], 'gold'];
    }

    // Fetch data from user_table for the pie chart
    $query = "SELECT `Designation`, COUNT(*) as `Count` FROM `user_table` WHERE `user_type` = 'staff' GROUP BY `Designation`";
    $getData = $con->query($query);
    ?>

    <script>
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawBarChart);

        function drawBarChart() {
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($chartData); ?>);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: 'stringify',
                    sourceColumn: 1,
                    type: 'string',
                    role: 'annotation'
                },
                2]);

            var options = {
                title: 'Hotel Expense',
                width: 410,
                height: 400,
                bar: { groupWidth: '95%' },
                legend: { position: 'none' },
            };

            var chart = new google.visualization.BarChart(document.getElementById('barchart_values'));
            chart.draw(view, options);
        }

        google.charts.setOnLoadCallback(drawPieChart);

        function drawPieChart() {
            var data = google.visualization.arrayToDataTable([
                ['Designation', 'Count'],
                <?php
                $data = '';
                if ($getData->num_rows > 0) {
                    while ($row = $getData->fetch_object()) {
                        $data .= '["' . $row->Designation . '",' . $row->Count . '],';
                    }
                }
                echo $data;
                ?>
            ]);

            var options = {
                title: 'Staff Members According to Designation',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('container'));
            chart.draw(data, options);
        }
    </script>

    <?php
    // Close connection
    $con->close();
    ?>
</body>

</html>
