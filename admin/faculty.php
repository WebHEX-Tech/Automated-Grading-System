<?php 

session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 2)) {
  header('location: ../login');
}

?>

<!DOCTYPE html>
<html lang="en">
<?php 
	$title = 'Admin | Faculty';
  $faculty_page = 'active';
	include '../includes/admin_head.php';
?>
<body>
  <div class="home">
    <div class="side">
      <?php
        require_once('../includes/admin_sidepanel.php')
      ?> 
    </div>
    <main>
      <div class="header">
        <?php
          require_once('../includes/admin_header.php')
        ?>
      </div>

      <div class="flex-md-nowrap p-1 title_page shadow" style="background-color: whitesmoke;" >
        <div class="d-flex align-items-center">
          <div class="container-fluid d-flex justify-content-center">
            <span class="fs-2 fw-bold h1 m-0 brand-color">FACULTY</span>
          </div>
        </div>
      </div>

      <div class="m-4">
        <div class="content brand-border-color mw-100 rounded shadow py-3">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link text-dark active" id="nav-regular-tab" data-bs-toggle="tab" data-bs-target="#nav-regular" type="button" role="tab" aria-controls="nav-regular" aria-selected="true">Regular Lecturer</button>
              <button class="nav-link text-dark" id="nav-visiting-tab" data-bs-toggle="tab" data-bs-target="#nav-visiting" type="button" role="tab" aria-controls="nav-visiting" aria-selected="false">Visiting Lecturer</button>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-regular" role="tabpanel" aria-labelledby="nav-regular-tab">
              <div class="search-keyword col-12 flex-lg-grow-0 d-flex my-2 px-2">
    
                <div class="form-group col-12 col-sm-auto flex-sm-grow-1 flex-lg-grow-0 ms-lg-auto">
                  <select name="school_year" id="school_year" class="form-select me-md-2">
                    <option value="">School Year</option>
                    <option value="?">?</option>
                    <option value="2004">2004</option>
                  </select>
                </div>

                <div class="form-group mx-4 col-12 col-sm-auto flex-sm-grow-1 flex-lg-grow-0">
                  <select name="semester" id="semester" class="form-select me-md-2">
                    <option value="">Semester</option>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                  </select>
                </div>

                <div class="input-group">
                  <input type="text" name="keyword" id="keyword" placeholder="Search" class="form-control">
                  <button class="btn btn-outline-secondary brand-bg-color" type="button"><i class='bx bx-search' aria-hidden="true" ></i></button>
                </div>
                <a href="./add_faculty" class="btn btn-outline-secondary btn-add ms-3 brand-bg-color" type="button"><i class='bx bx-plus-circle'></i></a>
              </div>

              <?php
                $student_array = array(
                  array(
                    'emp_id' => '2024-00001',
                    'full_name' => 'Oliveros, Franklin I',
                    'email' => 'sssssssssssssss@email.com',
                    'academic_rank' => '2',
                    'designation' => '3',
                    'num_of_hours' => '25',
                    'school_yr' => '2004',
                    'sem' => '2nd',
                  ),
                );
              ?>
              <table id="main_faculty_regular" class="table table-striped table-sm" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Employee ID</th>
                    <th>Full Name</th> 
                    <th>Email</th>
                    <th>Academic Rank</th>
                    <th>Designation</th>
                    <th>Number of hours per week</th>
                    <th>School Year</th>
                    <th>Semester</th>
                    <th width="5%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $counter = 1;
                    foreach ($student_array as $item){
                  ?>
                    <tr>
                      <td><?= $counter ?></td>
                      <td><?= $item['emp_id'] ?></td>
                      <td><?= $item['full_name'] ?></td>
                      <td><?= $item['email'] ?></td>
                      <td><?= $item['academic_rank'] ?></td>
                      <td><?= $item['designation'] ?></td>
                      <td><?= $item['num_of_hours'] ?></td>
                      <td><?= $item['school_yr'] ?></td>
                      <td><?= $item['sem'] ?></td>
                      <td class="text-center">
                        <a href="# "><i class='bx bx-edit text-success' ></i></a>
                        <i class='bx bx-trash-alt text-danger' ></i>
                      </td>
                    </tr>
                  <?php
                    $counter++;
                    }
                  ?>
                </tbody>
              </table>
            </div>

            <div class="tab-pane fade" id="nav-visiting" role="tabpanel" aria-labelledby="nav-visiting-tab">
              <div class="search-keyword col-12 flex-lg-grow-0 d-flex my-2">
                    
                <div class="form-group col-12 col-sm-auto flex-sm-grow-1 flex-lg-grow-0 ms-lg-auto">
                  <select name="school_year" id="school_year" class="form-select me-md-2">
                    <option value="">School Year</option>
                    <option value="?">?</option>
                    <option value="2004">2004</option>
                  </select>
                </div>
                <div class="form-group mx-4 col-12 col-sm-auto flex-sm-grow-1 flex-lg-grow-0">
                  <select name="semester" id="semester" class="form-select me-md-2">
                    <option value="">Semester</option>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                  </select>
                </div>
                <div class="input-group">
                  <input type="text" name="keyword" id="keyword" placeholder="Search" class="form-control">
                  <button class="btn btn-outline-secondary brand-bg-color" type="button"><i class='bx bx-search' aria-hidden="true" ></i></button>
                </div>
                <a href="./add_faculty.php" class="btn btn-outline-secondary btn-add ms-3 brand-bg-color" type="button"><i class='bx bx-plus-circle'></i></a>
              </div>
              <?php
                $student_array = array(
                  array(
                    'emp_id' => '2024-00001',
                    'full_name' => 'Oliveros, Franklin I',
                    'email' => 'sssssssssssssss@email.com',
                    'academic_rank' => '2',
                    'designation' => '3',
                    'num_of_hours' => '25',
                    'school_yr' => '2004',
                    'sem' => '2nd',
                  ),
                );
              ?>
              <table id="main_faculty_visiting" class="table table-striped table-sm" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Employee ID</th>
                    <th>Full Name</th> 
                    <th>Email</th>
                    <th>Academic Rank</th>
                    <th>Designation</th>
                    <th>Number of hours per week</th>
                    <th>School Year</th>
                    <th>Semester</th>
                    <th width="5%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $counter = 1;
                    foreach ($student_array as $item){
                  ?>
                    <tr>
                      <td><?= $counter ?></td>
                      <td><?= $item['emp_id'] ?></td>
                      <td><?= $item['full_name'] ?></td>
                      <td><?= $item['email'] ?></td>
                      <td><?= $item['academic_rank'] ?></td>
                      <td><?= $item['designation'] ?></td>
                      <td><?= $item['num_of_hours'] ?></td>
                      <td><?= $item['school_yr'] ?></td>
                      <td><?= $item['sem'] ?></td>
                      <td class="text-center">
                        <a href="# "><i class='bx bx-edit text-success' ></i></a>
                        <i class='bx bx-trash-alt text-danger' ></i>
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
        </div>
      </div>
    </main>
  </div>

  <script src="./js/main.js"></script>
  <script src="./js/faculty_table.js"></script>
</body>
</html>