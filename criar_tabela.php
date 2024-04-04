<?php
// Connect to your database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create a new table for a raffle
function createRaffleTable($raffleId) {
    global $conn;
    $tableName = "raffle_" . $raffleId;
    $sql = "CREATE TABLE $tableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        number INT(6) NOT NULL
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table $tableName created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

// Function to generate numbers for a raffle and insert them into the table
function generateRaffleNumbers($raffleId, $numberOfNumbers) {
    global $conn;
    $tableName = "raffle_" . $raffleId;

    // Generate and insert numbers into the table
    for ($i = 1; $i <= $numberOfNumbers; $i++) {
        $number = rand(1, 100); // Generate a random number (adjust range as needed)
        $sql = "INSERT INTO $tableName (number) VALUES ($number)";
        if ($conn->query($sql) !== TRUE) {
            echo "Error inserting number: " . $conn->error;
        }
    }
}

// Example usage:
$raffleId = 1; // ID of the raffle
$numberOfNumbers = 100; // Number of numbers to generate for the raffle

// Create a new table for the raffle
createRaffleTable($raffleId);

// Generate numbers for the raffle and insert them into the table
generateRaffleNumbers($raffleId, $numberOfNumbers);

// Close the database connection
$conn->close();
?>