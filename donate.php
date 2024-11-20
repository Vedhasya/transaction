<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $account_holder_name = $_POST['Accountholder name'];
    $account_number = $_POST['Account Number'];
    $ifsc_code = $_POST['IFSC Code'];
    $phone_number = $_POST['Phone Number'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $confirm_password = $_POST['Comfirm Password'];

    // Validate input
    if (empty($account_holder_name) || empty($account_number) || empty($ifsc_code) || empty($phone_number) || empty($email) || empty($password) || empty($confirm_password)) {
        // Handle validation errors (redirect back with error message)
        header("Location: index.html?error=emptyfields");
        exit();
    }

    if ($password !== $confirm_password) {
        // Handle password mismatch
        header("Location: index.html?error=passwordmismatch");
        exit();
    } else {
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tech";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO users (account_holder_name, account_number, ifsc_code, phone_number, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $account_holder_name, $account_number, $ifsc_code, $phone_number, $email, $hashed_password);
        $stmt->execute();

        // Close statement and database connection
        $stmt->close();
        $conn->close();

        // Redirect back with a success message
        header("Location: index.html?success=true");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the form page
    header("Location: index.html");
    exit();
}
?>
