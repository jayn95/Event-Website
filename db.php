<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="dbstyle.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
    <nav>
        <div class="navbar">
            <div class="profile-wrapper">
                <a href="#" class="profile-button img">
                    <img src="profile.png" alt="Profile Icon">
                </a>
                <div class="new-sidebar">
                    <button class="logout-button"><a href="login.php">Log Out</a></button>
                </div>
            </div>

            <div class="navbar">
                <div class="dropdown">
                    <button class="dropbtn" onclick="toggleSidebar()">&#9776;</button>
                    <div class="sidebar">
                        <a href="#">Chart</a>
                        <a href="#">Table</a>
                    </div>
                </div>
                <div class="title">DASHBOARD</div>
            </div>
        </div>
    </nav>

    <div class="ticket-container">
        <p class="ticket-count">Purchased Tickets: <span id="purchasedTickets">Loading...</span></p>
        <p class="ticket-count">Tickets Available: <span id="availableTickets">Loading...</span></p>
    </div>

    <div class="ticket-container">
        <p class="ticket-count">VIP Ticket Count: <span id="vipTicketCount">Loading...</span></p>
        <p class="ticket-count">General Admission Ticket Count: <span id="genAdTicketCount">Loading...</span></p>
    </div>

    <div class="ticket-container">
        <form method="post">
            <label for="vipTicketAdjustment">Adjust VIP Ticket Count:</label>
            <input type="number" id="vipTicketAdjustment" name="vipTicketAdjustment" min="0" step="1">

            <label for="genAdTicketAdjustment">Adjust General Admission Ticket Count:</label>
            <input type="number" id="genAdTicketAdjustment" name="genAdTicketAdjustment" min="0" step="1">

            <button type="submit" name="adjustTickets">Adjust Tickets</button>
        </form>
    </div>

    <?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ticket_system';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Step 1: Retrieve user data
    $sql = "SELECT id, first_name, last_name, email, ticket_purchase, ticket_type, approval_status FROM ticket_owner";
    $result = $conn->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    // Step 2: Display user data and approval status in a table
    echo '<table>
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Ticket Purchased</th>
                      <th>Ticket Type</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>';

    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . $user['id'] . '</td>';
        echo '<td>' . $user['first_name'] . '</td>';
        echo '<td>' . $user['last_name'] . '</td>';
        echo '<td>' . $user['email'] . '</td>';
        echo '<td>' . $user['ticket_purchase'] . '</td>';
        echo '<td>' . $user['ticket_type'] . '</td>';
        echo '<td>' . $user['approval_status'] . '</td>';
        echo '<td>';
        echo '<form method="post">';
        echo '<input type="hidden" name="ticketId" value="' . $user['id'] . '">';
        echo '<select name="newStatus">';
        echo '<option value="approved">Approved</option>';
        echo '<option value="pending">Pending</option>';
        echo '</select>';
        echo '<button type="submit">Update</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>
          </table>';

    // Step 3: Handle the form submission to update the approval status
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ticketId = $_POST['ticketId'];
        $newStatus = $_POST['newStatus'];

        // Update the ticket status in the database
        $sql = "UPDATE ticket_owner SET approval_status = '$newStatus' WHERE id = $ticketId";
        $conn->query($sql);
    }

    // Step 4: Handle the form submission to adjust the ticket counts
    if (isset($_POST['adjustTickets'])) {
        $vipTicketAdjustment = $_POST['vipTicketAdjustment'];
        $genAdTicketAdjustment = $_POST['genAdTicketAdjustment'];

        // Update the ticket counts in the database
        $sql = "UPDATE ticket_owner SET ticket_purchase = ticket_purchase + $vipTicketAdjustment WHERE ticket_type = 'VIP'";
        $conn->query($sql);

        $sql = "UPDATE ticket_owner SET ticket_purchase = ticket_purchase + $genAdTicketAdjustment WHERE ticket_type = 'General Admission'";
        $conn->query($sql);
    }

    // Step 5: Fetch ticket counts and update the HTML elements using JavaScript
    $ticketCountSql = "SELECT COUNT(*) AS purchased_tickets, (SELECT COUNT(*) FROM ticket_owner WHERE approval_status = 'approved') AS available_tickets, (SELECT COUNT(*) FROM ticket_owner WHERE ticket_type = 'VIP') AS vip_tickets, (SELECT COUNT(*) FROM ticket_owner WHERE ticket_type = 'General Admission') AS gen_ad_tickets FROM ticket_owner";
    $ticketCountResult = $conn->query($ticketCountSql);

    if ($ticketCountResult->num_rows > 0) {
        $ticketCounts = $ticketCountResult->fetch_assoc();
        echo '<script>';
        echo 'document.getElementById("purchasedTickets").innerText = ' . $ticketCounts['purchased_tickets'] . ';';
        echo 'document.getElementById("availableTickets").innerText = ' . $ticketCounts['available_tickets'] . ';';
        echo 'document.getElementById("vipTicketCount").innerText = ' . $ticketCounts['vip_tickets'] . ';';
        echo 'document.getElementById("genAdTicketCount").innerText = ' . $ticketCounts['gen_ad_tickets'] . ';';
        echo '</script>';
    }

    mysqli_close($conn);
    ?>

    <script src="db.js"></script>


</body>
</html>
