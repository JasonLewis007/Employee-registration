<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch territories
$sql = "SELECT territory_number FROM territories";
$result = $conn->query($sql);

$territories = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $territories[] = $row['territory_number'];
    }
}

// Return territories as JSON
header('Content-Type: application/json');
echo json_encode($territories);

// Close the connection
$conn->close();
?>
