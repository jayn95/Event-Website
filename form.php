<html>
    <head>
        <title>TIcketing System</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <a href="login.php">Admin Login</a>
        <h1>Ticketing System</h1>
        <form method="post" action="purchase_ticket.php">
            <label for="first_name">First Name:</label>
            <input type="text" id = "first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="ticket_purchase">Number of Tickets to Purchase:</label>
            <input type="ticket_purchase" name="ticket_purchase" required>

            <label for="ticket_type">Ticket Type:</label>
            <select id="ticket_type" name="ticket_type" required>
                <option value="">-- Select a Ticket Type --</option>
                <option value="1">General Admission</option>
                <option value="2">VIP</option>
            </select>

            <input type="submit" value="Purchase Ticket">
        </form>
    </body>
    </html>