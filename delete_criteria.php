<?php
session_start();

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
    header('location: ./login.php');
    exit();
}

// Check if criteria_id is provided in the URL
if (!isset($_GET['criteria_id'])) {
    header('location: ./subject_setting.php'); // Redirect if criteria_id is not provided
    exit();
}

// Retrieve the criteria_id from the URL
$criteria_id = $_GET['criteria_id'];

// Include database connection
include_once("./classes/database.php");

// Create an instance of the Database class
$database = new Database();
// Establish the database connection
$connection = $database->connect();

// Check if the connection is successful
if ($connection) {
    try {
        // Prepare the SQL statement to delete the criteria
        $stmt = $connection->prepare("DELETE FROM subject_setting WHERE criteria_id = :criteria_id");

        // Bind parameter
        $stmt->bindParam(':criteria_id', $criteria_id);

        // Execute the statement
        $stmt->execute();

        // Redirect to subject_setting.php after successful deletion
        header('location: ./subject_setting.php');
        exit();
    } catch (PDOException $e) {
        // Handle database error
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Failed to connect to the database.</p>";
}
?>
