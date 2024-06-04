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

// Function to generate a unique employee number
function generateEmployeeNumber($territory, $username) {
    return strtoupper($territory) . '-' . uniqid();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and validate inputs
    $territory = $_POST['territory'];
    $user = strtoupper($_POST['username']);

    if (!empty($territory) && !empty($user) && ctype_upper($user)) {
        // Generate employee number
        $employee_number = generateEmployeeNumber($territory, $user);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO employees (territory, username, employee_number) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $territory, $user, $employee_number);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the form with the employee number in the query string
            header("Location: index.html?employee_number=" . urlencode($employee_number));
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Invalid input. Make sure the username is in all caps.";
    }
}

// Close the connection
$conn->close();
?>
