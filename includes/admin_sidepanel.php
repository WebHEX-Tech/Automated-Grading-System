<div id="sidebarMenu" class="sidepanel d-flex flex-column flex-shrink-0 p-3 border-end border-dark position-fixed" style="max-width: 215px; height: 100%; background-color: white;">
  <a href="./index" class="d-flex align-items-center justify-content-center mb-md-0 link-dark text-decoration-none">
    <img src="../img/wmsu_logo.png" class="me-2" alt="" width="50px" height="50px">
    <span class="fs-2 h1 m-0 brand-color ">Admin</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="./index" class="nav-link link-dark d-flex align-items-center mb-2 <?= $curriculum_page ?>" aria-current="page">
        <i class='bx bxs-book-alt fs-4'></i>
        <span class="fs-6 ms-2">Curriculum</span>
      </a>
    </li>

    <li class="nav-item">
      <div class="btn-group d-flex flex-column">
        <div class="link-grp d-flex justify-content-between gap-1">
          <a href="./profiling.php" class="nav-link link-dark d-flex align-items-center mb-2 w-100 <?= $profiling_page ?>" type="button">
            <i class='bx bxs-user-detail fs-4'></i>
            <span class="fs-6 ms-2">Profiling</span>
          </a>
          <button class="btn btn-toggle link-dark d-flex align-items-center mb-2 nav-link <?= $profiling_page ?>" data-bs-toggle="collapse" data-bs-target="#profiling_toggle" aria-expanded="false">
            <i class='bx bx-chevron-down'></i>
          </button>
        </div>

        <?php
        require_once '../classes/department.class.php';
        require_once '../tools/functions.php';

        $department = new Department();
        $department_array = $department->show();

        $show_collapse = false;
        if (isset($_GET['department_id'])) {
          $show_collapse = true;
        }
        ?>

        <div class="collapse<?= ($show_collapse && strpos($_SERVER['REQUEST_URI'], 'profiling') !== false ? ' show' : '') ?>" id="profiling_toggle" style="">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <?php
            if ($department_array) {
              foreach ($department_array as $item) {
                $active = false;
              
                if (strpos($_SERVER['REQUEST_URI'], 'profiling') !== false && isset($_GET['department_id']) && $_GET['department_id'] == $item['department_id']) {
                  $active = true;
                }
              
                // Assign the correct icon based on the department name
                $icon = '';
                if ($item['department_name'] == 'Department of Computer Science') {
                  $icon = 'bx bx-code-alt fs-4';
                } elseif ($item['department_name'] == 'Department of Information Technology') {
                  $icon = 'bx bxs-network-chart fs-4';
                } else {
                  $icon = 'bx bx-git-commit fs-4';
                }
                ?>
                <li>
                  <a href="./profiling?department_id=<?= $item['department_id'] ?>" class="link-dark nav-link d-flex align-items-center <?= ($active ? ' active' : '') ?>">
                    <i class='<?= $icon ?>'></i>
                    <span class="fs-6 ms-2"><?= $item['department_name'] ?></span>
                  </a>
                </li>
                <?php
              }
            }
            ?>
          </ul>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <div class="btn-group d-flex flex-column">
        <div class="link-grp d-flex justify-content-between gap-1">
          <a href="./manage_acc.php" class="nav-link link-dark d-flex align-items-center mb-2 w-100 <?= $manage_acc ?>" type="button">
            <i class='bx bxs-cog fs-4'></i>
            <span class="fs-6 ms-2">Manage Account</span>
          </a>
          <button class="btn btn-toggle link-dark d-flex align-items-center mb-2 nav-link <?= $manage_acc ?> " data-bs-toggle="collapse" data-bs-target="#mnge_acc_toggle" aria-expanded="false">
            <i class='bx bx-chevron-down'></i>
          </button>
        </div>

        <div class="collapse <?= ($acc_setup || $user_acc) ? 'show' : '' ?>" id="mnge_acc_toggle" style="">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <!-- <li>
              <a href="./acc_setup.php" class="link-dark nav-link <?= $acc_setup ?>">
                <i class='bx bx-git-commit'></i>
                <span class="fs-6 ms-2">Account Setup</span>
              </a>
            </li> -->
            <li>
              <a href="./user_acc.php" class="link-dark nav-link <?= $user_acc ?>">
                <i class='bx bxs-user-circle fs-4'></i>
                <span class="fs-6 ms-2">User Account</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <div class="btn-group d-flex flex-column">
        <div class="link-grp d-flex justify-content-between gap-1">
          <a href="./faculty" class="nav-link link-dark d-flex align-items-center mb-2 w-100 <?= $faculty_page ?>">
            <i class='bx bxs-group fs-4'></i>
            <span class="fs-6 ms-2">Faculty</span>
          </a>
          <button class="btn btn-toggle link-dark d-flex align-items-center mb-2 nav-link <?= $faculty_page ?>" data-bs-toggle="collapse" data-bs-target="#faculty_toggle" aria-expanded="false">
            <i class='bx bx-chevron-down'></i>
          </button>
        </div>
        
        <?php
        require_once '../classes/department.class.php';
        require_once '../tools/functions.php';
        
        $department = new Department();
        $department_array = $department->show();
        
        $show_collapse = false;
        if (isset($_GET['department_id'])) {
          $show_collapse = true;
        }
        ?>
            
        <div class="collapse<?= ($show_collapse && strpos($_SERVER['REQUEST_URI'], 'faculty') !== false ? ' show' : '') ?>" id="faculty_toggle" style="">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <?php
            if ($department_array) {
              foreach ($department_array as $item) {
                $active = false;
              
                if (strpos($_SERVER['REQUEST_URI'], 'faculty') !== false && isset($_GET['department_id']) && $_GET['department_id'] == $item['department_id']) {
                  $active = true;
                }
              
                // Assign the correct icon based on the department name
                $icon = '';
                if ($item['department_name'] == 'Department of Computer Science') {
                  $icon = 'bx bx-code-alt fs-4';
                } elseif ($item['department_name'] == 'Department of Information Technology') {
                  $icon = 'bx bxs-network-chart fs-4';
                } else {
                  $icon = 'bx bx-git-commit fs-4';
                }
                ?>
                <li>
                  <a href="./faculty?department_id=<?= $item['department_id'] ?>" class="link-dark nav-link d-flex align-items-center <?= ($active ? ' active' : '') ?>">
                    <i class='<?= $icon ?>'></i>
                    <span class="fs-6 ms-2"><?= $item['department_name'] ?></span>
                  </a>
                </li>
                <?php
              }
            }
            ?>
          </ul>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <a href="./grade" class="nav-link link-dark d-flex align-items-center mb-2  <?= $grade_page ?>">
        <i class='bx bxs-graduation fs-4'></i>
        <span class="fs-6 ms-2">Grade</span>          
      </a>
    </li>
    <li class="nav-item">
      <a href="./admin_settings" class="nav-link link-dark d-flex align-items-center mb-2  <?= $setting_page ?>">
        <i class='bx bx-cog fs-4'></i>
        <span class="fs-6 ms-2">Settings</span>          
      </a>
    </li>
  </ul>
  <hr>
    <div class="account dropdown">
      <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="../img/profile-img/<?= $_SESSION['profile_image'] ?>" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong><?= ucwords($_SESSION['name']) ?></strong>
      </a>
      <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
        <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
      </ul>
    </div>
</div>

<script>
  $(document).ready(function(){
    // Toggle collapse on button click
    $('.btn-toggle').click(function(){
      var collapseId = $(this).attr('data-bs-target');
      $('.collapse').not(collapseId).collapse('hide');
    });
  
    // Show collapse if its corresponding link is clicked
    $('.btn-toggle-nav .nav-link').click(function(){
      var collapseId = $(this).attr('href');
      $(collapseId).toggleClass('show');
    });
  });

  $(document).ready(function(){
    // Toggle collapse on button click
    $('.btn-toggle').click(function(){
      var collapseId = $(this).attr('data-bs-target');
      $('.collapse').not(collapseId).collapse('hide');
    });
  });
</script>

