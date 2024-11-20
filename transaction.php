<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $medicine_name = $_POST['medicine_name'];
    $quantity = $_POST['quantity'];
    $expiry_date = $_POST['expiry_date'];
    $donor_name = $_POST['donor_name'];
    $contact_info = $_POST['contact_info'];

    // Validate input (you can add more validation as needed)
    if (empty($medicine_name) || empty($quantity) || empty($expiry_date) || empty($donor_name) || empty($contact_info)) {
        // Handle validation errors (you can redirect back to the form with an error message)
        header("Location: new_transaction.php?error=emptyfields");
        exit();
    } else {
        // Connect to the database (replace these values with your actual database credentials)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tech";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO transactions (medicine_name, quantity, expiry_date, donor_name, contact_info) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiss", $medicine_name, $quantity, $expiry_date, $donor_name, $contact_info);
        $stmt->execute();

        // Close statement and database connection
        $stmt->close();
        $conn->close();

        // Redirect back to the form with a success message
        header("Location: index.html?success=true");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the form page
    header("Location: transaction.html");
    exit();
}
?>