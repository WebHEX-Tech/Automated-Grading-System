<?php 

session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 2)) {
  header('location: ../login');
}

require_once '../tools/functions.php';
require_once '../classes/curr_year.class.php';
require_once '../classes/user.class.php';

if (isset($_POST['add_curr-year'])) {

  $user = new User();

  $record = $user->fetch($_SESSION['user_id']);
  $user->user_id = $_SESSION['user_id'];

  $curr_year = new Curr_year();
  //sanitize
  $curr_year->user_id = $_SESSION['user_id'];
  $curr_year->year_start = htmlentities($_POST['year_start']);
  $curr_year->year_end = htmlentities($_POST['year_end']);

  if (        
    validate_field($curr_year->year_start) && !$curr_year->is_year_exist($curr_year->year_start) &&
    validate_field($curr_year->year_end)
  ) {
    if ($curr_year->add()) {
      header('location: ./index.php');
      $message = 'Curriculum Year is successfuly added.';
      // }elseif(check_email($_POST['email'])){
      //     $message = 'Email is already taken.'; check ko sana email if taken na -hilal
    } else {
      $message = 'Something went wrong adding Curriculum Year.';
    }
  }

}

$currentYear = date('Y');

?>

<!DOCTYPE html>
<html lang="en">
<?php
	$title = 'Admin | Add Curriculum';
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
            <span class="fs-2 fw-bold h1 m-0 brand-color">Add Curriculum</span>
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
                                                                                                                                                                                              } ?>">
                <?php
                if (isset($_POST['year_start']) && !validate_field($_POST['year_start'])) {
                ?>
                  Please enter starting Year
                <?php
                }

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
                                                                                                                                                    } ?>">
                <?php
                if (isset($_POST['year_end']) && !validate_field($_POST['year_end'])) {
                ?>
                  Please enter End Year
                <?php
                }
                
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
          <button type="submit" class="btn brand-bg-color" id="add_curr-year" name="add_curr-year">Add</button>
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