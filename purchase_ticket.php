<?php

function insertPurchaseDetails()
{   $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ticket_system";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $ticket_purchase = $_POST['ticket_purchase'];
    //Perform necessary validation and processing of the ticektData

    //Insert the ticketData into the database
    $query = "INSERT INTO Ticket_owner (first_name, last_name, email, ticket_purchase, ticket_type) VALUES ('$first_name', '$last_name', '$email', '$ticket_purchase', '$ticket_type')";

    //Execute the query
    $result = mysqli_query($conn, $query);

    //Check if the query executed successfully
    if ($result) {
        return true; //Purchase successful
    }
    else {
        return false; //Purchase failed
    }
}

//Attempt to insert the purchase details into the database
$purchaseResult = insertPurchaseDetails();

//Display the acknowledgement message based on the purchase result
if ($purchaseResult) {
    echo "Thank you for purchasing a ticket! Your purchase was successful.";
}
else {
    echo "We apologize, but your ticket purchase was unsuccessful. Please try again later.";
}
?>