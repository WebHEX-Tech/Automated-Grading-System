<?php
session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 1)) {
    header('location: ../login');
}

require_once './tools/functions.php';
require_once './classes/profiling.class.php';
require_once './classes/faculty_sched.class.php';
require_once './classes/faculty_subs.class.php';
require_once './classes/sub_students.class.php';

$profiling = new Profiling();
$sched = new Faculty_Sched();
$fac_subs = new Faculty_Subjects();
$students = new Sub_Students();

$info = $profiling->fetchEMP($_SESSION['emp_id']);

$subject = $fac_subs->getProf($_GET['faculty_sub_id']);
$studentList = $students->showBySubject($_GET['faculty_sub_id']);
?>

<!DOCTYPE html>
<html lang="en">
<?php
$title = $subject['sub_code'];
$faculty_page = 'active';
include './includes/head.php';
?>

<body>
    <div class="home">
        <div class="side">
        <?php require_once('./includes/sidepanel.php') ?>
        </div>
        <main>
            <div class="header">
            <?php require_once('./includes/header.php') ?>
            </div>

            <div class="flex-md-nowrap p-1 title_page shadow" style="background-color: whitesmoke;">
                <div class="d-flex align-items-center">
                    <a href="./index"
                        class="bg-none d-flex align-items-center">
                        <i class='bx bx-chevron-left fs-2 brand-color'></i>
                    </a>
                    <div class="container-fluid d-flex justify-content-center">
                        <span class="fs-2 fw-bold h1 m-0 brand-color">Students List</span>
                    </div>
                </div>
            </div>

            <div class="m-4">

                <div class="content container-fluid mw-100 border rounded shadow p-3">
                    <div class="d-flex flex-column align-items-center">
                        <h3 class="brand-color"><?= ucwords($subject['sub_name']) ?></h3>
                        <h4><?= $subject['sub_code'] ?> (<?= $subject['yr_sec'] ?>)</h4>
                    </div>

                    <table id="student_table" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Student Name (Last, First, MI)</th>
                                <th>Email</th>
                                <th>Year & Section</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            foreach ($studentList as $student): ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td><?= $student['student_id'] ?></td>
                                    <td><?= ucwords($student['fullName']) ?></td>
                                    <td><?= $student['email'] ?></td>
                                    <td><?= $student['year_section'] ?></td>
                                </tr>
                                <?php
                                $counter++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="./js/main.js"></script>
    <script>
        $(document).ready(function () {
            dataTable = $("#student_table").DataTable({
                pageLength: 5,
                scrollX: true,
                lengthChange: false, // Disable length change
                'columnDefs': [{
                    'targets': [1, 2, 3, 4], /* column index */
                    'orderable': true, /* true or false */
                }]
            });
        });
    </script>
</body>

</html>