<?php
session_start();

// Redirect if user is not logged in or not an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 2) {
    header('location: ../login');
    exit();
}

require_once '../tools/functions.php';
require_once '../classes/sub_students.class.php';
require_once '../classes/faculty_subs.class.php';

$fac_subs = new Faculty_Subjects();
$student = new Sub_Students();

$subject = $fac_subs->getProf($_GET['faculty_sub_id']);

$success = false;
$errors = '';
$message = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $student_id = trim($_POST['student_id']);
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['middlename']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $year_section = trim($_POST['year_section']);

    // Validate inputs
    if (empty($student_id)) {
        $errors = 'Student ID is required.';
    } elseif (empty($firstname)) {
        $errors = 'First name is required.';
    } elseif (empty($lastname)) {
        $errors = 'Last name is required.';
    } else if (!preg_match('/^[a-zA-Z0-9._%+-]+@wmsu\.edu\.ph$/', $email)) {
        $errors = 'Only @wmsu.edu.ph emails are allowed.';
    } elseif (empty($year_section)) {
        $errors = 'Year and section are required.';
    } else {
        $student->faculty_sub_id = htmlentities($_GET['faculty_sub_id']);
        $student->student_id = htmlentities($student_id);
        $student->student_firstname = ucwords(strtolower(htmlentities($firstname)));
        $student->student_middlename = !empty($middlename) ? ucwords(strtolower(htmlentities($middlename))) : '';
        $student->student_lastname = ucwords(strtolower(htmlentities($lastname)));
        $student->email = htmlentities($email);
        $student->year_section = htmlentities($year_section);

        if ($student->add()) {
            $success = true;
            $message = 'Student successfully added.';
        } else {
            $errors = 'Failed to add the student. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
$title = 'Admin | Add Student';
$curriculum_page = 'active';
include '../includes/admin_head.php';
?>

<body>
    <div class="home">
        <div class="side">
            <?php require_once('../includes/admin_sidepanel.php'); ?>
        </div>

        <main>
            <div class="header">
                <?php require_once('../includes/admin_header.php'); ?>
            </div>

            <div class="flex-md-nowrap p-1 title_page shadow" style="background-color: whitesmoke;">
                <div class="d-flex align-items-center">
                    <button onclick="history.back()" class="bg-none"><i
                            class='bx bx-chevron-left fs-2 brand-color'></i></button>
                    <div class="container-fluid d-flex justify-content-center">
                        <span class="fs-2 fw-bold h1 m-0 brand-color">Add Student</span>
                    </div>
                </div>
            </div>

            <div class="m-4">
                <form action="" method="POST">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($errors) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success gap-2">
                            <i class='bx bx-check-circle'></i> <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" class="form-control" id="student_id" placeholder="eg. 202105376"
                                    name="student_id" value="<?= htmlspecialchars($_POST['student_id'] ?? '') ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstname" placeholder="eg. Juan Robert"
                                    name="firstname" value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="middlename" class="form-label">* Middle Name</label>
                                <input type="text" class="form-control" id="middlename" placeholder="eg. Dela"
                                    name="middlename" value="<?= htmlspecialchars($_POST['middlename'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastname" placeholder="eg. Cruz"
                                    name="lastname" value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="eg. xt202511235@wmsu.edu.ph"
                                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="year_section" class="form-label">Year and Section</label>
                                <input type="text" class="form-control" id="year_section" placeholder="eg. BEED 2A"
                                    name="year_section"
                                    value="<?= htmlspecialchars($subject['yr_sec'] ?? $_POST['year_section'] ?? '') ?>"
                                    required>

                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" onclick="history.back()" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn brand-bg-color" name="add_student">Add</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="./js/main.js"></script>
    <?php if ($success): ?>
        <script>
            setTimeout(function () {
                window.location.href = "./sub_students?sched_id=<?= $_GET['sched_id'] ?>&department_id=<?= $_GET['department_id'] ?>&faculty_sub_id=<?= $_GET['faculty_sub_id'] ?>"
            }, 1500);
        </script>
    <?php endif; ?>
</body>

</html>