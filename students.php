<?php 
session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 1)) {
  header('location: ./login.php');
  exit(); // Add an exit statement after redirection
}

// Include database connection
include_once("./classes/database.php");

// Create an instance of the Database class
$database = new Database();
// Establish the database connection
$connection = $database->connect();

// Initialize an empty array to store student data
$student_array = array();

// Check if the connection is successful
if ($connection) {
    try {
        // Fetch student data from the database
        $stmt = $connection->query("SELECT * FROM student");

        // Check if data is fetched successfully
        if ($stmt) {
            // Fetch all rows as an associative array
            $student_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Handle query execution error
            throw new Exception("Error fetching student data.");
        }
    } catch (Exception $e) {
        // Handle exception
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
} else {
    // Handle connection error
    echo "<p>Failed to connect to the database.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<?php 
$title = 'Student list';
$student_page = 'active';
include './includes/head.php';
?>
<body>
  <div class="home">
    <div class="side">
      <?php
      require_once('./includes/sidepanel.php');
      ?> 
    </div>
    <main>
      <div class="header" >
        <?php
        require_once('./includes/header.php');
        ?>
      </div>
      
      <div class="flex-md-nowrap p-1 title_page shadow" style="background-color: whitesmoke;" >
        <div class="d-none d-md-block">
          <div class="container-fluid d-flex justify-content-center">
            <span class="fs-2 h1 m-0">Students list</span>
          </div>
        </div>
      </div>

      <div class="m-4">
        <div class="table-responsive overflow-hidden">
          <div class="row g-2 mb-2 m-0">
            <div class="col-3">
              <button type="button" class="btn border border-danger dropdown-toggle form-select" data-bs-toggle="dropdown">
                Subject Code
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">CS140</a></li>
                <li><a class="dropdown-item" href="#">CS137</a></li>
              </ul>
            </div>

            <div class="col-3">
              <!-- Button trigger modal -->
              <button type="button" class="btn brand-bg-color" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Import
              </button>
  
              <!-- Modal -->
              <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">import file</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="styles.css">
</head>
</html>
<body>

  <input type="file" id="csv-file" accept=".csv">
  <br><br>
  <div id="field-dropdowns"></div>
  <br>
  <table id="data-table" class="display">
    <thead>
      <tr></tr>
    </thead>
    <tbody></tbody>
  </table>

  <!-- Link to jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Link to DataTables JavaScript -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
 <!-- Link to PapaParse JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
  <!-- Link to your custom JavaScript file -->
  <script src="script.js"></script>
</body>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-primary">Add</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="search-keyword col-12 flex-lg-grow-0 d-flex">
              <div id="MyButtons" class="d-flex me-4 mb-md-2 mb-lg-0 col-12 col-md-auto"></div>
              <div class="input-group justify-content-end"> 
                <input type="text" name="keyword" id="keyword" placeholder="Search Student" class="form-control">
                <button class="btn btn-outline-secondary brand-bg-color" type="button"><i class='bx bx-search' aria-hidden="true" ></i></button>
              </div>
              <a href="./add_student.php" class="btn btn-outline-secondary btn-add ms-3 brand-bg-color" type="button"><i class='bx bx-plus-circle'></i></a>
           </div>
          </div>
          <table id="students" class="table table-striped table-sm" style="width:100%">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Last Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Middle Name</th>
                <th scope="col">Extension</th>
                <th scope="col">Student ID</th>
                <th scope="col">Email</th>
                <th scope="col" width="5%">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $counter = 1;
            foreach ($student_array as $item) {
            ?>
            <tr>
              <td><?= $counter ?></td>
              <td><?= $item['lname'] ?></td>
              <td><?= $item['fname'] ?></td>
              <td><?= $item['mname'] ?></td>
              <td><?= $item['extension'] ?></td>
              <td><?= $item['studentid'] ?></td>
              <td><?= $item['studentemail'] ?></td>
              <td class="text-center">
                  <a href="edit_student.php?studentid=<?= $item['studentid'] ?>"><i class='bx bx-edit text-success'></i></a>
                  <!-- Delete Button with Modal -->
                  <a href="delete_student.php?studentid=<?= $item['studentid'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['studentid'] ?>"><i class='bx bx-trash-alt text-danger'></i></a>

                  <!-- Delete Confirmation Modal -->
                  <div class="modal fade" id="deleteModal<?= $item['studentid'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $item['studentid'] ?>" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="deleteModalLabel<?= $item['studentid'] ?>">Confirm Deletion</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  Are you sure you want to delete this student?
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <a href="../delete_student.php?studentid=<?= $item['studentid'] ?>" class="btn btn-danger">Delete</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </td>

            </tr>
            <?php
            $counter++;
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
 
  <?php
  require_once('./includes/js.php');
  ?>
  <script src="./js/student_table.js"></script>
</body>
</html>
