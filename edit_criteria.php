<?php
session_start();

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
    header('location: ./login.php');
    exit();
}

// Include database connection
include_once("./classes/database.php");

// Check if criteria_id is provided in the URL
if (!isset($_GET['criteria_id'])) {
    header('location: ./subject_setting.php'); // Redirect if criteria_id is not provided
    exit();
}

// Retrieve the criteria_id from the URL
$criteria_id = $_GET['criteria_id'];

// Initialize variables
$criteria_name = '';
$criteria_weight = '';

// Check if the form is submitted for updating criteria
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input data
    $criteria_name = trim($_POST['criteria_name']);
    $criteria_weight = trim($_POST['criteria_weight']);

    // Update the criteria in the database
    $database = new Database();
    $connection = $database->connect();

    if ($connection) {
        try {
            // Prepare the SQL statement to update the criteria
            $stmt = $connection->prepare("UPDATE subject_setting SET criteria_name = :criteria_name, criteria_weight = :criteria_weight WHERE criteria_id = :criteria_id");

            // Bind parameters
            $stmt->bindParam(':criteria_name', $criteria_name);
            $stmt->bindParam(':criteria_weight', $criteria_weight);
            $stmt->bindParam(':criteria_id', $criteria_id);

            // Execute the statement
            $stmt->execute();

            // Redirect to subject_setting.php after successful update
            header('location: ./subject_setting.php');
            exit();
        } catch (PDOException $e) {
            // Handle database error
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Failed to connect to the database.</p>";
    }
} else {
    // Fetch the criteria details from the database
    // Create an instance of the Database class
    $database = new Database();
    // Establish the database connection
    $connection = $database->connect();

    if ($connection) {
        try {
            // Prepare the SQL statement to fetch criteria details
            $stmt = $connection->prepare("SELECT * FROM subject_setting WHERE criteria_id = :criteria_id");

            // Bind parameter
            $stmt->bindParam(':criteria_id', $criteria_id);

            // Execute the statement
            $stmt->execute();

            // Fetch the criteria details
            $criteria = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if criteria exists
            if ($criteria) {
                $criteria_name = $criteria['criteria_name'];
                $criteria_weight = $criteria['criteria_weight'];
            } else {
                echo "<p>Criteria not found.</p>";
                exit();
            }
        } catch (PDOException $e) {
            // Handle database error
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Failed to connect to the database.</p>";
    }
}
?>

<?php

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
    header('location: ./login.php');
    exit();
}

// Include database connection
include_once("./classes/database.php");

// Check if criteria_id is provided in the URL
if (!isset($_GET['criteria_id'])) {
    header('location: ./subject_setting.php'); // Redirect if criteria_id is not provided
    exit();
}

// Retrieve the criteria_id from the URL
$criteria_id = $_GET['criteria_id'];

// Initialize variables
$criteria_name = '';
$criteria_weight = '';

// Check if the form is submitted for updating criteria
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input data
    $criteria_name = trim($_POST['criteria_name']);
    $criteria_weight = trim($_POST['criteria_weight']);

    // Update the criteria in the database
    $database = new Database();
    $connection = $database->connect();

    if ($connection) {
        try {
            // Prepare the SQL statement to update the criteria
            $stmt = $connection->prepare("UPDATE subject_setting SET criteria_name = :criteria_name, criteria_weight = :criteria_weight WHERE criteria_id = :criteria_id");

            // Bind parameters
            $stmt->bindParam(':criteria_name', $criteria_name);
            $stmt->bindParam(':criteria_weight', $criteria_weight);
            $stmt->bindParam(':criteria_id', $criteria_id);

            // Execute the statement
            $stmt->execute();

            // Redirect to subject_setting.php after successful update
            header('location: ./subject_setting.php');
            exit();
        } catch (PDOException $e) {
            // Handle database error
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Failed to connect to the database.</p>";
    }
} else {
    // Fetch the criteria details from the database
    // Create an instance of the Database class
    $database = new Database();
    // Establish the database connection
    $connection = $database->connect();

    if ($connection) {
        try {
            // Prepare the SQL statement to fetch criteria details
            $stmt = $connection->prepare("SELECT * FROM subject_setting WHERE criteria_id = :criteria_id");

            // Bind parameter
            $stmt->bindParam(':criteria_id', $criteria_id);

            // Execute the statement
            $stmt->execute();

            // Fetch the criteria details
            $criteria = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if criteria exists
            if ($criteria) {
                $criteria_name = $criteria['criteria_name'];
                $criteria_weight = $criteria['criteria_weight'];
            } else {
                echo "<p>Criteria not found.</p>";
                exit();
            }
        } catch (PDOException $e) {
            // Handle database error
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Failed to connect to the database.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject Settings</title>
</head>
<body>
<?php 

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 1)) {
    header('location: ./login.php');
    exit(); // Make sure to exit after redirection
}

include './includes/head.php';
?>
  <div class="home">
    <div class="side">
      <?php
        require_once('./includes/sidepanel.php')
      ?> 
    </div>
    <main>
      <div class="header" >
      <?php
        require_once('./includes/header.php')
      ?>
      </div>
      
      <div class="flex-md-nowrap p-1 title_page shadow" style="background-color: whitesmoke;" >
        <div class="d-flex align-items-center">
          <button onclick="history.back()" class="bg-none" ><i class='bx bx-chevron-left fs-2 brand-color'></i></button>
          <div class="container-fluid d-flex justify-content-center">
            <span class="fs-2 h1 m-0">Edit Criteria</span>
          </div>
        </div>
      </div>

      <div class="m-5 py-3">
        <form action="../tools/add_setting_standard_form.php"method="post" name="studentaddsubjectsettingform">
          <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
              <div class="mb-3">
                <label for="criteria_name" class="form-label">Criteria Name</label>
                <input type="text" class="form-control" id="criteria_name" name="criteria_name" aria-describedby="criteria_name" required> <!-- Added required attribute for validation -->
              </div>
              <div class="mb-3">
                <label for="criteria_weight" class="form-label">Weight</label>
                <input type="number" class="form-control" id="criteria_weight" name="criteria_weight" aria-describedby="criteria_weight" required> <!-- Added required attribute for validation -->
              </div>
            </div>
          </div>
          <button onclick="history.back()" type="button" class="btn btn-secondary">Cancel</button>
          <button type="submit" name="Submit" class="btn brand-bg-color">Save</button>
        </form>
      </div>

    </main>
  </div>

  <script src="./js/main.js"></script>
  
</body>
</html>
