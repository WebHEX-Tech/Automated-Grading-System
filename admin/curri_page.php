<?php 

session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 2)) {
  header('location: ../login');
}

require_once '../classes/year_lvl.class.php';
require_once '../classes/semester.class.php';

$year_lvl = new Year_lvl();
$semester = new Semester();

$year_level_id = $_GET['year_level_id'];
$semester_id = $_GET['semester_id'];

if (!isset($_GET['year_id']) || 
    !isset($_GET['course_id']) || 
    !isset($_GET['time_id']) || 
    !isset($_GET['year_level_id']) || 
    !isset($_GET['semester_id']) ||

    empty($_GET['year_id']) || 
    empty($_GET['course_id']) || 
    empty($_GET['time_id']) || 
    empty($_GET['year_level_id']) || 
    empty($_GET['semester_id']) ||

    !$year_lvl->exists($year_level_id) || 
    !$semester->exists($semester_id)) {

  header('Location: ./index');
  exit;
} 

?>

<!DOCTYPE html>
<html lang="en">
<?php 
	$title = 'Grade Posted';
  $curriculum_page = 'active';
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
          <button onclick="history.back()" class="bg-none d-flex align-items-center" ><i class='bx bx-chevron-left fs-2 brand-color'></i></button>
          <div class="container-fluid d-flex justify-content-center">
            <span class="fs-2 fw-bold h1 m-0 brand-color">
              <?php 
              require_once '../classes/course_select.class.php';

              $course_curr = new Course_curr();
              $course_id = $_GET['course_id'] ?? ''; // Assuming you're passing curr_year_id in the URL

              $courseName = $course_curr->getCourseNameById($course_id);
              ?>
              <span class='fs-2 fw-bold h1 m-0 brand-color'>
                <?php
                if ($courseName) {
                  echo "{$courseName['name']}";
                } else {
                  echo "Invalid Curriculum Year";
                }
                ?>  
            
              Curriculum
            </span>
          </div>
        </div>
      </div>

      <div class="m-4">
        
        <div class="row row-cols-1 row-cols-md-2 d-flex justify-content-between">
          <div class="col">
            <div class="dropdown">
              <?php 
                require_once '../classes/year_lvl.class.php';

                $year_lvl = new Year_lvl;
                $yearlvlarray = $year_lvl->show();
              ?>
              <button class="btn border dropdown-toggle form-select border-danger mb-4" type="button" id="year_lvl" data-bs-toggle="dropdown" aria-expanded="false">
                <?php 

                  $year_level_id = $_GET['year_level_id'] ?? '';

                  $yearLvl = $year_lvl->getYearLvlById($year_level_id);

                  if ($yearLvl) {
                    echo "{$yearLvl['year_level']}";
                  } else {
                    echo "Select Year Level";
                  }
                ?>  
              </button>
              <ul class="dropdown-menu" aria-labelledby="year_lvl">
                <?php 
                  foreach ($yearlvlarray as $item): 
                ?>
                <li><a class="dropdown-item" href="./curri_page?year_id=<?= $_GET['year_id'] ?>&course_id=<?= $_GET['course_id'] ?>&time_id=<?= $_GET['time_id'] ?>&year_level_id=<?= $item['year_level_id'] ?><?php echo isset($_GET['semester_id']) ? '&semester_id=' . $_GET['semester_id'] : '' ?>">
                  <?= $item['year_level'] ?>
                </a></li>
                <?php 
                  endforeach; 
                ?>
              </ul>
            </div>
          </div>

          <div class="col">
            <div class="dropdown">
              <?php 
                require_once '../classes/semester.class.php';

                $semester = new semester;
                $semesterarray = $semester->show();
              ?>
              <button class="btn border dropdown-toggle form-select border-danger mb-4" type="button" id="semester" data-bs-toggle="dropdown" aria-expanded="false">
              <?php 
                $semester_id = $_GET['semester_id'] ?? '';
                                
                $sem = $semester->getSemesterById($semester_id);
                                
                if ($sem) {
                  echo "{$sem['semester']}";
                } else {
                  echo "Select Semester";
                }
              ?>  
              </button>
              <ul class="dropdown-menu" aria-labelledby="semester">
                <?php 
                  foreach ($semesterarray as $item): 
                ?>
                <li><a class="dropdown-item" href="./curri_page?year_id=<?= $_GET['year_id'] ?>&course_id=<?= $_GET['course_id'] ?>&time_id=<?= $_GET['time_id'] ?><?php echo isset($_GET['year_level_id']) ? '&year_level_id=' . $_GET['year_level_id'] : '' ?>&semester_id=<?= $item['semester_id'] ?>">
                  <?= $item['semester'] ?>
                </a></li>
                <?php 
                  endforeach; 
                ?>
              </ul>
            </div>
          </div>
        </div>

        <div class="content container-fluid mw-100 border rounded shadow p-3">
          <div class="d-flex flex-column align-items-center mb-2">
            <h3> 
              <?php 
                require_once '../classes/curr_year.class.php';

                $curr_year = new Curr_year();
                $year_id = $_GET['year_id'] ?? ''; // Assuming you're passing curr_year_id in the URL

                $yearRange = $curr_year->getYearRangeById($year_id);
                if ($yearRange) {
                  echo "S.Y {$yearRange['year_start']}-{$yearRange['year_end']}";
                } else {
                  echo "Invalid Curriculum Year";
                }
              ?>
            </h3>
            <h4>
              <?php 
                require_once '../classes/semester.class.php';
                
                $semester = new semester;
                $semester_id = $_GET['semester_id'] ?? '';
                                  
                $sem = $semester->getSemesterById($semester_id);
                                
                if ($sem) {
                  echo "{$sem['semester']}";
                } else {
                  echo "Select Semester";
                }
              ?>
            </h4>
          </div>  

          <div class="search-keyword col-12 flex-lg-grow-0 d-flex justify-content-between">
            <div id="MyButtons" class="d-flex me-4 mb-md-2 mb-lg-0 col-12 col-md-auto"></div>
            <div class="input_width d-flex" style="width: 40% !important;">
              <div class="input-group">
                <input type="text" name="keyword" id="keyword" placeholder="Search" class="form-control">
                <button class="btn btn-outline-secondary brand-bg-color" type="button"><i class='bx bx-search' aria-hidden="true" ></i></button>
              </div>
              <a href="./curri_add_sub?year_id=<?= $_GET['year_id'] ?>&course_id=<?= $_GET['course_id'] ?>&time_id=<?= $_GET['time_id'] ?>&year_level_id=<?= $_GET['year_level_id'] ?>&semester_id=<?= $_GET['semester_id'] ?>" class="btn btn-outline-secondary btn-add ms-3 brand-bg-color" type="button"><i class='bx bx-plus-circle'></i></a>
            </div>
          </div>
          
          <?php
            require_once '../classes/curri_page.class.php';
            require_once '../tools/functions.php';

            $curr_table = new Curr_table();

            // Fetch and display table data
            $year_id = $_GET['year_id'] ?? '';
            $course_id = $_GET['course_id'] ?? '';
            $time_id = $_GET['time_id'] ?? '';
            $year_level_id = $_GET['year_level_id'] ?? '';
            $semester_id = $_GET['semester_id'] ?? '';
            $curr_tableArray = $curr_table->show($year_id, $course_id, $time_id, $year_level_id, $semester_id);
            $counter = 1;   
          ?>
          
          <table id="curriculum" class="cell-border" style="width:100%">
            <thead>
              <tr>
                <th rowspan="2" class="align-middle">#</th>
                <th rowspan="2" class="align-middle">Subject</th> <!--Code & description-->
                <th rowspan="2" class="align-middle">Prequisite</th>
                <th colspan="3" class="text-center border-bottom-0">Unit</th>
                <th rowspan="2" class="align-middle text-center" width="8%">Action</th>
              </tr>
              <tr>
                <th width="10%">lec</th>
                <th width="10%">lab</th>
                <th width="10%">total</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($curr_tableArray) {
                  foreach ($curr_tableArray as $item) {
              ?>
                <tr>
                  <td><?= $counter ?></td>
                  <td><?= $item['sub_code'] ?> - <?= $item['sub_name']?></td>
                  <td><?= $item['sub_prerequisite'] ?></td>
                  <td><?= $item['lec'] ?></td>
                  <td><?= $item['lab'] ?></td>
                  <td><?= $item['lec'] + $item['lab'] ?></td>
                  <td class="text-center">
                    <a href="./curri_edit_sub?curr_id=<?= $item['curr_id'] ?>&year_id=<?= $_GET['year_id'] ?>&course_id=<?= $_GET['course_id'] ?>&time_id=<?= $_GET['time_id'] ?>&year_level_id=<?= $_GET['year_level_id'] ?>&semester_id=<?= $_GET['semester_id'] ?>"><i class='bx bx-edit text-success'></i></a>
                    <button class="delete-btn bg-none" data-subject-id="<?= $item['curr_id'] ?>"><i class='bx bx-trash-alt text-danger'></i></button>
                  </td>
                </tr>
              <?php
                  $counter++;
                  }
                }
              ?>
            </tbody>
          </table>

        </div>
      </div>

    </main>
  </div>

  <!-- confirm delete modal markup -->
  <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this subject?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <script src="./js/main.js"></script>
  <script src="./js/curriculum-table.js"></script>
  <script src="./js/modal_delete_confirm.js"></script>
  
</body>
</html>