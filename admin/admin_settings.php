<?php 
session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 2)) {
  header('location: ../login');
}

require_once '../tools/functions.php';
require_once '../classes/user.class.php';

// Automatically identify the user ID from session
$user_id = $_SESSION['user_id'];

$user = new User();
$record = $user->fetch($user_id);
$user->f_name = $record['f_name'];
$user->l_name = $record['l_name'];
$user->m_name = $record['m_name'];
$user->user_id = $user_id;

if (isset($_POST['save_settings'])) {
  try {
    $user->f_name = htmlentities($_POST['f_name']);
    $user->l_name = htmlentities($_POST['l_name']);
    $user->m_name = htmlentities($_POST['m_name']);

    // Validation
    $errors = [];
    if (!validate_field($user->f_name)) {
      $errors[] = 'Please enter First Name';
    }
    if (!validate_field($user->l_name)) {
      $errors[] = 'Please enter Last Name';
    }

    if (empty($errors)) {
      if ($user->edit()) {
        // Update session with new values
        $_SESSION['f_name'] = $user->f_name;
        $_SESSION['l_name'] = $user->l_name;
        $_SESSION['m_name'] = $user->m_name;

        // Redirect to same page after updating
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
      } else {
        $message = 'Something went wrong updating user details.';
      }
    } else {
      throw new Exception(implode('<br>', $errors));
    }
  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
}

if (isset($_POST['saveimage'])) {
  $uploaddir = '../img/profile-img/';
  $fileName = basename($_FILES['profile']['name']);
  $uploadfile = $uploaddir . $fileName;

  if (move_uploaded_file($_FILES['profile']['tmp_name'], $uploadfile)) {
    if (isset($_POST['addimage']) && isset($message)) {
      echo "<script> alert('File is valid, and was successfully uploaded.')</script>";
    }
  } else {
    echo "<script> alert('Failed Upload')</script>";
  }

  $user->profile_image = $_FILES['profile']['name'];

  if (validate_field($user->profile_image)) {
    if ($user->edit_profile($user_id)) {
      $_SESSION['profile_image'] = $user->profile_image;
      $message = 'image is successfully added Image.';
    } else {
      $message = 'Something went wrong adding Image.';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php 
  $title = 'Settings';
  $setting_page = 'active';
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
            <span class="fs-2 fw-bold h1 m-0 brand-color">Settings</span>
          </div>
        </div>
      </div>

      <div class="m-4">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="container-fluid d-flex justify-content-start">
            <span class="fs-2 fw-bold h1 m-0 brand-color mb-3">User Settings</span>
          </div>
          <div class="row row-cols-1 row-cols-md-2">
            <div class="col-md-4">
              <div class="border shadow p-3 mb-5 bg-body rounded">
                <div class="user">
                  <div class="profile-pic">
                    <label class="label brand-border-color d-flex flex-column" for="file" style="border-width: 4px !important;">
                      <i class="bx bxs-camera-plus"></i>
                      <span>Change Image</span>
                    </label>
                    <img src="../img/profile-img/<?= $_SESSION['profile_image'] ?>" id="output" class="img-fluid">
                    <input id="file" type="file" name="profile" accept="image/png, image/jpeg" onchange="validateFile(event)">
                  </div>
                  <div class="d-flex justify-content-center align-items-center mb-2">
                    <button type="submit" name="saveimage" class="btn brand-bg-color">Save Image</button>
                  </div>
                  <div class="name d-flex justify-content-center align-items-center">
                    <p class="username fw-bold"><?= ucwords($_SESSION['name']) ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                  <div class="mb-3">
                    <label for="f_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="f_name" name="f_name" aria-describedby="f_name" value="<?php if (isset($_POST['f_name'])) {
                                                                                                                               echo $_POST['f_name'];
                                                                                                                             } else if (isset($user->f_name)) {
                                                                                                                               echo $user->f_name;
                                                                                                                             } ?>"
                    oninput="capitalizeFirstLetter(this)">
                  </div>
                </div>
                <div class="col">
                  <div class="mb-3">
                    <label for="l_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="l_name" name="l_name" aria-describedby="l_name" value="<?php if (isset($_POST['l_name'])) {
                                                                                                                               echo $_POST['l_name'];
                                                                                                                             } else if (isset($user->l_name)) {
                                                                                                                               echo $user->l_name;
                                                                                                                             } ?>"
                    oninput="capitalizeFirstLetter(this)">
                  </div>
                </div>
                <div class="col">
                  <div class="mb-3">
                    <label for="m_name" class="form-label">Middle Name*</label>
                    <input type="text" class="form-control" id="m_name" name="m_name" aria-describedby="m_name" value="<?php if (isset($_POST['m_name'])) {
                                                                                                                               echo $_POST['m_name'];
                                                                                                                             } else if (isset($user->m_name)) {
                                                                                                                               echo $user->m_name;
                                                                                                                             } ?>"
                    oninput="capitalizeFirstLetter(this)">
                  </div>
                </div>
              </div>
              <div class="mb-2">
                <button type="button" class="btn btn-toggle link-dark d-flex align-items-center nav-link p-0" data-bs-toggle="collapse" data-bs-target="#pw_input_toggle" aria-expanded="false">
                  <i class='bx bxs-key me-2'></i>
                  <span>Change password</span>
                </button>
              </div>

              <div class="collapse" id="pw_input_toggle">
                <div class="mb-3">
                  <label for="current_pw" class="form-label">Current Password</label>
                  <input type="text" class="form-control" id="current_pw" aria-describedby="current_pw">
                </div>
                <div class="mb-3">
                  <label for="new_pw" class="form-label">New Password</label>
                  <input type="text" class="form-control" id="new_pw" aria-describedby="new_pw">
                </div>
                <div class="mb-3">
                  <label for="confirm_pw" class="form-label">Confirm New Password</label>
                  <input type="text" class="form-control" id="confirm_pw" aria-describedby="confirm_pw">
                </div>
              </div>
              
              
            </div>
          </div>
          <div class="d-flex justify-content-end gap-2">
            <button type="submit" name="save_settings" class="btn brand-bg-color">Change</button>
          </div>
        </form>
        
      </div>

    </main>
  </div>

  <script src="./js/main.js"></script>

  <script>
    var validateFile = function(event) {
      var fileInput = event.target;
      var filePath = fileInput.value;
      var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;
    
      if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type. Only PNG and JPEG files are allowed.');
        fileInput.value = '';
        return false;
      }
    
      var image = document.getElementById("output");
      image.src = URL.createObjectURL(event.target.files[0]);
    };
  </script>

  <script>
    function capitalizeFirstLetter(input) {
      input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
    }
  </script>

  <script>
    $(document).ready(function() {
      $('#saveImage').click(function() {
        var formData = new FormData($('#profileForm')[0]);
        
        $.ajax({
          url: '../includes/upload_profile.php',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            alert(response);
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Error occurred while uploading image: ' + error);
          }
        });
      });
    });

    $(document).ready(function() {
      $('#save_settings').click(function(e) {
        e.preventDefault();
      
        var formData = $('#settings_form').serialize();
      
        $.ajax({
          url: 'update_settings',
          type: 'POST',
          data: formData,
          success: function(response) {
            alert('Settings updated successfully!');
            location.reload();
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Error occurred while updating settings: ' + error);
          }
        });
      });
    });
  </script>
  
</body>
</html>