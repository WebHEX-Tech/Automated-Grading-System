<?php 

session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 1)) {
    header('location: ./login.php');
    exit(); // Make sure to exit after redirection
}

// Include database connection
include_once("./classes/database.php");

// Create an instance of the Database class
$database = new Database();
// Establish the database connection
$connection = $database->connect();

// Initialize an empty array to store subject settings data
$subject_settings_array = array();

// Check if the connection is successful
if ($connection) {
    try {
        // Fetch subject settings data from the database
        $stmt = $connection->query("SELECT * FROM subject_setting");

        // Check if data is fetched successfully
        if ($stmt) {
            // Fetch all rows as an associative array
            $subject_settings_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Handle query execution error
            throw new Exception("Error fetching subject settings data.");
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Setting</title>
    <?php include './includes/head.php'; ?>
</head>
<body>
  <div class="home">
    <div class="side">
      <?php require_once('./includes/sidepanel.php'); ?> 
    </div>
    <main>
      <div class="header">
      <?php require_once('./includes/header.php'); ?>
      </div>
      
      <div class="flex-md-nowrap p-1 title_page shadow" style="background-color: whitesmoke;">
        <div class="d-flex align-items-center">
          <div class="container-fluid d-flex justify-content-center">
            <span class="fs-2 h1 m-0">Subject Setting</span>
          </div>
        </div>
      </div>

      <div class="m-4">
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-4">
          <div class="col">
            <select type="button" class="btn border dropdown-toggle form-select border-danger mb-4" data-bs-toggle="dropdown">
              <option>Apply to all</option>
              <option>CS140</option>
              <option>CS137</option>
            </select>
          </div>
        </div>
        
        <div class="content brand-border-color mw-100 rounded shadow py-3">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link text-dark active" id="nav-midterm-tab" data-bs-toggle="tab" data-bs-target="#nav-midterm" type="button" role="tab" aria-controls="nav-midterm" aria-selected="true">Midterm</button>
              <button class="nav-link text-dark" id="nav-finalterm-tab" data-bs-toggle="tab" data-bs-target="#nav-finalterm" type="button" role="tab" aria-controls="nav-finalterm" aria-selected="false">Final Term</button>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-midterm" role="tabpanel" aria-labelledby="nav-midterm-tab">
              <div class="row m-2 row-cols-1 row-cols-md-2 d-flex justify-content-between">
                <form class="d-flex justify-content-start align-items-center">
                  <label class="me-2">Number of absences:</label>
                  <input class="border-bottom px-2" id="disabledTextInput" type="number" title="3" value="7" disabled>
                  <i class='bx bx-edit ms-2' id="edit_att_req"></i>
                </form>
                <div class="col-3 d-flex justify-content-end">
                  <a href="./add_standard-setting.php" class="btn btn-outline-secondary btn-add ms-3 brand-bg-color" type="button"><i class='bx bx-plus-circle'></i></a>
                </div>
              </div>

              <div class="d-flex justify-content-end">
              </div>

              <table id="subject_setting" class="table table-striped cell-border" style="width:100%">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Criteria</th>
                    <th scope="col">Weight</th>
                    <th scope="col" width="5%">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php $counter = 1; // Initialize counter variable ?>
                <?php foreach ($subject_settings_array as $item): ?>
                    <tr>
                      <td><?= $counter ?></td>
                      <td><?= $item['criteria_name'] ?></td>
                      <td><?= $item['criteria_weight'] ?></td>
                      <td class="text-center">
                        <a href="./edit_criteria.php?criteria_id=<?= $item['criteria_id'] ?>"><i class='bx bx-edit text-success'></i></a>
                        <a href="delete_criteria.php?criteria_id=<?= $item['criteria_id'] ?>" data-toggle="modal" data-target="#deleteModal<?= $item['criteria_id'] ?>"><i class='bx bx-trash-alt text-danger'></i></a>
                      </td>
                    </tr>
                <?php $counter++; // Increment counter variable ?>
                <?php endforeach; ?>
                <?php foreach ($subject_settings_array as $item): ?>
    
    
                
                 <!-- Delete Modal -->
              <div class="modal fade" id="deleteModal<?= $item['criteria_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              Are you sure you want to delete this criteria?
                          </div>
                          <div class="modal-footer">
                              <!-- Close button with data-dismiss attribute to close the modal -->
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                              <!-- Delete button to perform the delete action -->
                              <a href="./delete_criteria.php?criteria_id=<?= $item['criteria_id'] ?>" class="btn btn-danger">Delete</a>
                          </div>
                      </div>
                  </div>
                </div>

</div>

<?php endforeach; ?>
                  
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="nav-finalterm" role="tabpanel" aria-labelledby="nav-finalterm-tab">
              <!-- Content for Final Term -->
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>

  <?php require_once('./includes/js.php'); ?>
  <script src="./js/subject_setting-table.js"></script>
  
</body>
</html>
