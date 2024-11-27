<?php
// Include the database connection
include('db_connection.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_name = $_POST['username'];
    $user_password = $_POST['password'];

    // Hash the password using bcrypt
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert user data into the database
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the prepared statement
        $stmt->bind_param("ss", $user_name, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No form data received.";
}

// Close the database connection
$conn->close();
?>
