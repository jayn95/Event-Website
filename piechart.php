<!DOCTYPE html>
<html>
<head>
    <title>Ticket System</title>
    <link rel="stylesheet" type="text/css" href="chartstyle.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Ticket System</h1>

    <div id="chart-container">
        <canvas id="ticket-chart"></canvas>
    </div>

    <?php
    // Example ticket data
    $purchasedTickets = 150;
    $availableTickets = 350;

    // Calculate the percentage difference
    $unavailableTickets = $availableTickets - $purchasedTickets;
    $percentageUnavailable = ($unavailableTickets / $availableTickets) * 100;
    $percentageAvailable = 100 - $percentageUnavailable;
    ?>

    <script>
        // Create the pie chart
        const ctx = document.getElementById('ticket-chart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Available Tickets', 'Unavailable Tickets'],
                datasets: [{
                    data: [<?php echo $percentageAvailable; ?>, <?php echo $percentageUnavailable; ?>],
                    backgroundColor: ['#36A2EB', '#FF6384'],
                }],
            },
            options: {
                title: {
                    display: true,
                    text: 'Ticket Availability',
                },
            },
        });
    </script>

    <script src="chart.js"></script>
</body>
</html>
