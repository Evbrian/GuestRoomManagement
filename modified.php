<?php
// Include the database connection
include('db_connection.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form data is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomType = $_POST['roomType'];
    $checkInDate = $_POST['checkInDate'];
    $checkOutDate = $_POST['checkOutDate'];
    $guestCount = intval($_POST['guestCount']);
    $totalPrice = floatval($_POST['totalPrice']);

    // Prepare the SQL query to insert data into the database
    $sql = "INSERT INTO reservations (room_type, check_in_date, check_out_date, guest_count, total_price)
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssdi", $roomType, $checkInDate, $checkOutDate, $guestCount, $totalPrice);

        if ($stmt->execute()) {
            echo "Reservation successful!";
        } else {
            echo "Error executing statement: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
