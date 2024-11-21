<?php 

session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 1)) {
  header('location: ./login');
}

?>

<!DOCTYPE html>
<html lang="en">
<?php 
	$title = 'Home';
  $home_page = 'active';
	include './includes/head.php';
?>
<body>
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
        <div class="d-none d-md-block">
          <div class="container-fluid d-flex justify-content-center">
            <span class="fs-2 h1 m-0">Subject Assigned</span>
          </div>
        </div>
      </div>

      <div class="m-4">
        <div class="details">
          <p class="fw-bolder">Name: <span class="fw-bold brand-color"><?= ucwords($_SESSION['name']) ?></span></p>
          <p class="fw-bolder">Desgnation: <span class="fw-bold brand-color">Desgnation</span></p>
          <p class="fw-bolder">Academic Rank: <span class="fw-bold brand-color"><?= ucwords($_SESSION['acad_rank']) ?></span></p>
          <p class="fw-bolder">Release Time: <span class="fw-bold brand-color">Release Time</span></p>
        </div>

        <div class="content container-fluid mw-100 border rounded shadow p-3">
          <div class="row mb-4">
            <div class="col-6">
              <button type="button" class="btn border border-danger dropdown-toggle form-select" data-bs-toggle="dropdown">
                School Year
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">2021 - 2022</a></li>
                <li><a class="dropdown-item" href="#">2022 - 2023</a></li>
                <li><a class="dropdown-item" href="#">2023 - 2024</a></li>
              </ul>
            </div>
            
            <div class="col-6">
              <button type="button" class="btn border border-danger dropdown-toggle form-select" data-bs-toggle="dropdown">
                Semester
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Midterm</a></li>
                <li><a class="dropdown-item" href="#">Finalterm</a></li>
              </ul>
            </div>
          </div>

          <div class="d-flex flex-column align-items-center">
            <h3>S.Y 2023 - 2024</h3>
            <h4>First Semester</h4>
          </div>
          

          <table id="home_table" class="table table-striped" style="width:125%">
            <thead>
              <tr>
                <th rowspan="2" class="align-middle">#</th>
                <th rowspan="2" class="align-middle">Subject</th> <!-- Code & Description -->
                <th rowspan="2" class="align-middle">Subject ID</th>
                <th rowspan="2" class="align-middle">Prerequisite</th>
                <th rowspan="2" class="align-middle">Year/ Section</th>
                <th rowspan="2" class="align-middle"># of Students</th>
                <th colspan="2" class="text-center">Room</th>
                <th colspan="2" class="text-center">Schedules</th>
                <th colspan="3" class="text-center">Units</th>
              </tr>
              <tr>
                <th>Lecture</th>
                <th>Laboratory</th>
                <th>Lecture</th>
                <th>Laboratory</th>
                <th>Lec</th>
                <th>Lab</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td><a href="./subject-info.php" class="brand-color">CS137 - Software Engineering 1</a></td>
                <td>BSCS123456</td>
                <td>CS121, CS104</td>
                <td>BSCS 3B</td>
                <td>36</td>
                <td>lr1</td>
                <td>lab1</td>
                <td>MWF - 10:00-12:00</td>
                <td>TTH - 1:00-4:00</td>
                <td>2</td>
                <td>3</td>
                <td>5</td>
              </tr>
              <tr>
                <td>2</td>
                <td><a href="#" class="brand-color">CS140 - CS Elective 2</a></td>
                <td>BSCS654321</td>
                <td>CS128</td>
                <td>BSCS 3A</td>
                <td>23</td>
                <td>lr4</td>
                <td>lab2</td>
                <td>MWTH - 7:00-8:30</td>
                <td>TFS - 2:00-5:00</td>
                <td>3</td>
                <td>4</td>
                <td>7</td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>

    </main>
  </div>

  <script src="./js/main.js"></script>
  <script src="./js/index_table.js"></script>
  
</body>
</html>