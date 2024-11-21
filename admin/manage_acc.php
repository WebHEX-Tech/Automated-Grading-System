<?php 

session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 2)) {
  header('location: ../login');
}

require_once '../classes/user.class.php';
require_once '../tools/functions.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php 
	$title = 'Profiling';
  $manage_acc = 'active';
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
      <div class="header" >
      <?php
        require_once('../includes/admin_header.php')
      ?>
      </div>
      
      <div class="flex-md-nowrap p-1 title_page shadow" style="background-color: whitesmoke;" >
        <div class="d-flex align-items-center">
          <div class="container-fluid d-flex justify-content-center">
            <span class="fs-2 fw-bold h1 m-0 brand-color">User Account</span>
          </div>
        </div>
      </div>

      <div class="m-4">
        <div class="content container-fluid mw-100 border rounded shadow p-3">

          <div class="search-keyword col-12 flex-lg-grow-0 d-flex mb-2">

            <div class="search-keyword col-12 flex-lg-grow-0 d-flex my-2 px-2 justify-content-end">
              <div class="input-group w-50">
                <input type="text" name="keyword" id="keyword" placeholder="Search" class="form-control">
                <button class="btn btn-outline-secondary brand-bg-color" type="button"><i class='bx bx-search' aria-hidden="true" ></i></button>
              </div>
              <a href="./add_user" class="btn btn-outline-secondary btn-add ms-3 brand-bg-color" type="button"><i class='bx bx-plus-circle'></i></a>
            </div>
            
          </div>
          
          <?php
            $user = new User();
            $userArray = $user->show();
          ?>
          <table id="manage_acc" class="table table-striped table-sm" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Employee ID</th> <!--Code & description-->
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Email</th>
                <th>Designation</th>
                <th>Academic Rank</th>
                <th>Faculty Type</th>
                <th>Password</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $counter = 1;
                foreach ($userArray as $item){
                  if ($item['user_role'] == '1') {
              ?>
                  <tr>
                    <td><?= $counter ?></td>
                    <td><?= $item['emp_id'] ?></td>
                    <td><?= $item['l_name'] ?></td>
                    <td><?= $item['f_name'] ?></td>
                    <td><?= $item['m_name'] ?></td>
                    <td><?= $item['email'] ?></td>
                    <td><?= $item['designation'] ?></td>
                    <td><?= $item['acad_rank'] ?></td>
                    <td><?= $item['faculty_type'] ?></td>
                    <td><?= $item['password'] ?></td>
                  </tr>
              <?php
                  }
                $counter++;
                }
              ?>
            </tbody>
          </table>

        </div>
        
      </div>

    </main>
  </div>

  <script src="./js/main.js"></script>
  <script src="./js/manage_acc-table.js"></script>
</body>
</html>