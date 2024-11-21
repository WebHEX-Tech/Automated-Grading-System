<?php 

require_once '../tools/functions.php';
require_once '../classes/curr_year.class.php';
require_once '../classes/user.class.php';

session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 2)) {
  header('location: ../login');
}

if(isset($_GET['curr_year_id'])){
  $curr_year = new Curr_year();
  $record = $curr_year_id->fetch($_GET['curr_year_id']);
  $curr_year->year_start = $record['year_start'];
  $curr_year->year_end = $record['year_end'];
}

if (isset($_POST['edit_curr_year'])) {
  try {
    $user = new User();
    $record = $user->fetch($_SESSION['user_id']);
    $user->user_id = $_SESSION['user_id'];

    $curr_year = new Curr_year();
    //sanitize
    $curr_year->curr_year_id = $_GET['curr_year_id'];
    $curr_year->year_start = htmlentities($_POST['year_start']);
    $curr_year->year_end = htmlentities($_POST['year_end']);

    $curr_year = new Curr_year();

    // Validation
    $errors = [];
    if (!validate_field($curr_year->year_start)) {
      $errors[] = 'Please enter Subject Code';
    }
    if ($curr_year->is_year_exist($curr_year->year_start)) {
      $errors[] = 'Subject Code already exists';
    }
    if (!validate_field($curr_year->year_end)) {
      $errors[] = 'Please enter Subject Name';
    }

    if (empty($errors)) {
      if ($curr_year->edit()) {
        $redirect_url = './index?year_id=' . $_GET['year_id'];
        header('location: ' . $redirect_url);
        exit;
      } else {
        $message = 'Something went wrong editing subject.';
      }
    } else {
      throw new Exception(implode('<br>', $errors));
    }
  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
}

$currentYear = date('Y');
?>

<!DOCTYPE html>
<html lang="en">
<?php
	$title = 'Admin | Edit Curriculum';
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
          <button onclick="history.back()" class="bg-none" ><i class='bx bx-chevron-left fs-2 brand-color'></i></button>
          <div class="container-fluid d-flex justify-content-center">
            <span class="fs-2 fw-bold h1 m-0 brand-color">Edit Curriculum</span>
          </div>
        </div>
      </div>

      <div class="m-4">
        <form action="#" method="post">
        <?php
        if (isset($_POST['add_curr-year']) && isset($message)) {

          echo "<script> alert('" . $message . "'); window.location.href='./add_curri.php'; </script>";
        }
        ?>
          <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
              <div class="mb-3">
                <label for="year_start" class="form-label">Curriculum Year Start</label>
                <input type="number" class="form-control" placeholder="YYYY" min="1999" max="<?php echo $currentYear; ?>" id="year_start" aria-describedby="year_start" name="year_start" value="<?php if (isset($_POST['year_start'])) {
                                                                                                                                                                                                         echo $_POST['year_start'];
                                                                                                                                                                                                       } else if (isset($curr_year->year_start)) {
                                                                                                                                                                                                         echo $curr_year->year_start;
                                                                                                                                                                                                       } ?>">
                <?php
                if (isset($_POST['year_start']) && $curr_year->is_year_exist($_POST['year_start'])) {
                ?>
                  <p>Year already exists</p>
                <?php
                }
                ?>             
              </div>

              <div class="mb-3">
                <label for="year_end" class="form-label">Curriculum Year End</label>
                <input type="number" class="form-control" placeholder="YYYY" id="year_end" aria-describedby="year_end" name="year_end" value="<?php if (isset($_POST['year_end'])) {
                                                                                                                                                      echo $_POST['year_end'];
                                                                                                                                                    } else if (isset($curr_year->year_end)) {
                                                                                                                                                      echo $curr_year->year_end;
                                                                                                                                                    } ?>">
                <?php                 
                if (isset($_POST['year_end']) && ($_POST['year_end'] != (intval($_POST['year_start']) + 1))) {
                ?>
                  Year End must be equal to Year Start + 1
                <?php
                }
                ?>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-secondary">Cancel</button>
          <button type="submit" class="btn brand-bg-color" id="edit_curr_year" name="edit_curr_year">Save</button>
        </form>
      </div>

    </main>
  </div>

  <script src="./js/main.js"></script>
  
  <script>
  $(document).ready(function () {
    $('#year_start').on('input', function () {
      var startYear = parseInt($(this).val());
      if (!isNaN(startYear)) {
        $('#year_end').attr('value', startYear + 1);
      }
    });
  });

  </script>
  
</body>
</html>