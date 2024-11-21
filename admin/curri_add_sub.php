<?php 
require_once '../tools/functions.php';
require_once '../classes/curri_page.class.php';
require_once '../classes/user.class.php';
require_once '../classes/curr_year.class.php'; // Include the class file

session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 2)) {
  header('location: ../login');
}

if (isset($_POST['add_curr_sub'])) {
  $user = new User();
  $record = $user->fetch($_SESSION['user_id']);
  $user->user_id = $_SESSION['user_id'];

  $curr_table = new Curr_table();
  //sanitize
  $curr_table->user_id = $_SESSION['user_id'];
  $curr_table->curr_year_id = htmlentities($_POST['curr_year_id']);
  $curr_table->college_course_id = htmlentities($_POST['college_course_id']);
  $curr_table->time_id = htmlentities($_POST['time_id']);
  $curr_table->year_level_id = htmlentities($_POST['year_level_id']);
  $curr_table->semester_id = htmlentities($_POST['semester_id']);
  $curr_table->sub_code = htmlentities($_POST['sub_code']);
  $curr_table->sub_name = htmlentities($_POST['sub_name']);
  $curr_table->sub_prerequisite = htmlentities($_POST['sub_prerequisite']);
  $curr_table->lec = htmlentities($_POST['lec']);
  $curr_table->lab = htmlentities($_POST['lab']);

  $curr_year = new Curr_year(); // Instantiate the Curr_year class

  if (
    validate_field($curr_table->sub_code) && !$curr_table->is_subcode_exist($curr_table->sub_code) &&
    validate_field($curr_table->sub_name) &&
    validate_field($curr_table->sub_prerequisite) &&
    validate_field($curr_table->lec) &&
    validate_field($curr_table->lab)
  ) {
    if ($curr_table->add()) { // Use $curr_table instead of $curr_year
      $redirect_url = './curri_page?year_id=' . $_GET['year_id'] . '&course_id=' . $_GET['course_id'] . '&time_id=' . $_GET['time_id'] . '&year_level_id=' . $_GET['year_level_id'] . '&semester_id=' . $_GET['semester_id'];
      header('location: ' . $redirect_url);
      $message = 'Curriculum Year is successfully added.';
    } else {
      $message = 'Something went wrong adding Curriculum Year.';
    }
  }
}
?>



<!DOCTYPE html>
<html lang="en">
<?php 
	$title = 'Add Subject';
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
            <span class="fs-2 fw-bold h1 m-0 brand-color">Computer Science Curriculum</span>
          </div>
        </div>
      </div>

      <div class="m-4">
        <form action="#" method="post">
          <?php
          if (isset($_POST['add_curr_sub']) && isset($message)) {
            echo "<script> alert('" . $message . "'); window.location.href='./curri_add_sub'; </script>";
          }
          ?>
          <div class="row row-cols-1 row-cols-md-2 align-items-start">
            <div class="col">
              <div class="mb-3">
                <label for="sub_code" class="form-label">Code</label>
                <input type="text" class="form-control" id="sub_code" aria-describedby="sub_code" name="sub_code" value="<?php if (isset($_POST['sub_code'])) {
                                                                                                                                    echo $_POST['sub_code'];
                                                                                                                                  } ?>">
                <?php
                if (isset($_POST['sub_code']) && !validate_field($_POST['sub_code'])) {
                ?>
                  <p class="text-danger my-1">Please enter Subject Code</p>
                <?php
                }
                ?>
                <?php
                if (isset($_POST['sub_code']) && $curr_table->is_subcode_exist($_POST['sub_code'])) {
                ?>
                  <p>Subject code already exists</p>
                <?php
                }
                ?> 
              </div>

              <div class="mb-3">
                <label for="sub_name" class="form-label">Description</label>
                <input type="text" class="form-control" id="sub_name" aria-describedby="sub_name" name="sub_name" value="<?php if (isset($_POST['sub_name'])) {
                                                                                                                                    echo $_POST['sub_name'];
                                                                                                                                  } ?>">
                <?php
                if (isset($_POST['sub_name']) && !validate_field($_POST['sub_name'])) {
                ?>
                  <p class="text-danger my-1">Please enter Subject Name</p>
                <?php
                }
                ?>  
              </div>

              <div class="mb-3">
                <label for="sub_prerequisite" class="form-label">Prerequisite</label>
                <input type="text" class="form-control" id="sub_prerequisite" aria-describedby="sub_prerequisite" name="sub_prerequisite" value="<?php if (isset($_POST['sub_prerequisite'])) {
                                                                                                                                                        echo $_POST['sub_prerequisite'];
                                                                                                                                                        } ?>">
              </div>      
            </div>

            <div class="col">
              <div class="mb-3">
                <label for="lec" class="form-label">Lecture</label>
                <input type="number" class="form-control" id="lec" aria-describedby="lec" name="lec" value="<?php if (isset($_POST['lec'])) {
                                                                                                                    echo $_POST['lec'];
                                                                                                                  } ?>">
                <?php
                if (isset($_POST['lec']) && !validate_field($_POST['lec'])) {
                ?>
                  <p class="text-danger my-1">Cannot be empty</p>
                <?php
                }
                ?>  
              </div>

              <div class="mb-3">
                <label for="lab" class="form-label">Laboratory</label>
                <input type="number" class="form-control" id="lab" aria-describedby="lab" name="lab" value="<?php if (isset($_POST['lab'])) {
                                                                                                                    echo $_POST['lab'];
                                                                                                                  } ?>">
                <?php
                if (isset($_POST['lab']) && !validate_field($_POST['lab'])) {
                ?>
                  <p class="text-danger my-1">Cannot be empty</p>
                <?php
                }
                ?>  
              </div>

              <div class="mb-3">
                <label for="total_unit" class="form-label">Total Unit</label>
                <input type="number" class="form-control" id="total_unit" aria-describedby="total_unit" disabled  value="<?php if (isset($_POST['total_unit'])) {
                                                                                                                          echo $_POST['total_unit'];
                                                                                                                        } ?>">
              </div>
              
              <div class="mb-3 d-none">
                <label for="curr_year_id" class="form-label">year-id</label>
                <input type="number" class="form-control" id="curr_year_id" name="curr_year_id" aria-describedby="curr_year_id" value="<?php if (isset($_GET['year_id'])) {
                                                                                                                                                $curr_year_id = $_GET['year_id'];
                                                                                                                                                // Now you can use $id in your script
                                                                                                                                                echo "$curr_year_id";
                                                                                                                                              }
                                                                                                                                              ?>">
              </div>
              <div class="mb-3 d-none">
                <label for="college_course_id" class="form-label">course-id</label>
                <input type="number" class="form-control" id="college_course_id" name="college_course_id" aria-describedby="college_course_id" value="<?php if (isset($_GET['course_id'])) {
                                                                                                                                                $college_course_id = $_GET['course_id'];
                                                                                                                                                // Now you can use $id in your script
                                                                                                                                                echo "$college_course_id";
                                                                                                                                              }
                                                                                                                                              ?>">
              </div>
              <div class="mb-3 d-none">
                <label for="time_id" class="form-label">time_id</label>
                <input type="number" class="form-control" id="time_id" name="time_id" aria-describedby="time_id" value="<?php if (isset($_GET['time_id'])) {
                                                                                                                                                $time_id = $_GET['time_id'];
                                                                                                                                                // Now you can use $id in your script
                                                                                                                                                echo "$time_id";
                                                                                                                                              }
                                                                                                                                              ?>">
              </div>
              <div class="mb-3 d-none">
                <label for="year_level_id" class="form-label">year_level_id</label>
                <input type="number" class="form-control" id="year_level_id" name="year_level_id" aria-describedby="year_level_id" value="<?php if (isset($_GET['year_level_id'])) {
                                                                                                                                                $year_level_id = $_GET['year_level_id'];
                                                                                                                                                // Now you can use $id in your script
                                                                                                                                                echo "$year_level_id";
                                                                                                                                              }
                                                                                                                                              ?>">
              </div>
              <div class="mb-3 d-none">
                <label for="semester_id" class="form-label">semester_id</label>
                <input type="number" class="form-control" id="semester_id" name="semester_id" aria-describedby="semester_id" value="<?php if (isset($_GET['semester_id'])) {
                                                                                                                                                $semester_id = $_GET['semester_id'];
                                                                                                                                                // Now you can use $id in your script
                                                                                                                                                echo "$semester_id";
                                                                                                                                              }
                                                                                                                                              ?>">
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-end gap-2">
            <button type="button" onclick="cancelAdd();" class="btn btn-secondary">Cancel</button>
            <button type="submit" id="add_curr_sub" name="add_curr_sub" class="btn brand-bg-color">Submit</button>  
          </div>
        </form>
      </div>

    </main>
  </div>
  
  <script src="./js/main.js"></script>

  <script>
  $(document).ready(function () {
    $('#lec, #lab').on('input', function () {
      var lec = parseInt($('#lec').val()) || 0;
      var lab = parseInt($('#lab').val()) || 0;
      var totalUnit = lec + lab;
      $('#total_unit').val(totalUnit);
    });
  });
</script>

<script>
  function cancelAdd() {
    var yearId = encodeURIComponent('<?php echo $_GET['year_id']; ?>');
    var courseId = encodeURIComponent('<?php echo $_GET['course_id']; ?>');
    var timeId = encodeURIComponent('<?php echo $_GET['time_id']; ?>');
    var yearLevelId = encodeURIComponent('<?php echo $_GET['year_level_id']; ?>');
    var semesterId = encodeURIComponent('<?php echo $_GET['semester_id']; ?>');

    var redirectUrl = './curri_page.php?year_id=' + yearId + '&course_id=' + courseId + '&time_id=' + timeId + '&year_level_id=' + yearLevelId + '&semester_id=' + semesterId;

    window.location.href = redirectUrl;
  }
</script>
  
</body>
</html>