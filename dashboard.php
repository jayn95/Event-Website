<!DOCTYPE html>
<html>
    <head>
        <title>Ticketing System Dashboard</title>
        <style>
            /* CSS styling for the dashboard
            Add your custom CSS styles here */
        </style>
    </head>
    <body>
        <h1>Ticketing System Dashboard</h1>

        <div id="ticketsContainer">
            <?php
            // Establish database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ticket_system";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            //Fetch ticket data from the database
            $sql = "SELECT * FROM ticket_owner";
            $result = $conn->query($sql);

            //Display ticket data from the database

            // $sql = "SELECT * FROM ticket_owner";
            // $result = $conn->query($sql);

            //Display ticket data on the dashboard 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='ticket'>";
                    echo "<h3>Number of Tickets Purchased: ".$row['ticket_purchase']."</h3>";
                    echo "<p>Ticket Type: ".$row['ticket_type']."</p>";
                    echo "<p>Status: ".$row['approval_status']."</p>";
                    echo "</div>";
                }
            } else {
                echo "No tickets found.";
            }

            $conn->close();
        ?>
        </div>
    </body>
</html>