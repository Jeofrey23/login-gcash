<?php
// Database connection details
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$database = "user_credentials";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["reg_username"];
    $password = password_hash($_POST["reg_password"], PASSWORD_DEFAULT);
    $email = $_POST["reg_email"];

    // Prepare SQL statement to insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    // Execute the SQL statement
    if ($stmt->execute() === TRUE) {
        echo "User registered successfully!";
        // Redirect the user to login page
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
