<?php
session_start();

if (!isset($_SESSION['user_role']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 1)) {
    header('location: ../login');
}

require_once './tools/functions.php';
require_once './classes/profiling.class.php';
require_once './classes/faculty_sched.class.php';
require_once './classes/faculty_subs.class.php';
require_once './classes/students.class.php';
require_once './classes/grades.class.php';
require_once './classes/period.class.php';
require_once './classes/component.class.php';
require_once './classes/component_items.class.php';
require_once './classes/component_scores.class.php';

$profiling = new Profiling();
$sched = new Faculty_Sched();
$fac_subs = new Faculty_Subjects();
$students = new Students();
$studentsBySub = new Grades();
$period = new Periods();
$components = new SubjectComponents();
$comp_item = new ComponentItems();
$scores = new ComponentScores();

$selected_faculty_sub_id = isset($_GET['faculty_sub_id']) ? $_GET['faculty_sub_id'] : null;
$selected_tab = '';

$info = $profiling->fetchEMP($_SESSION['emp_id']);

$subject = $fac_subs->getProf($_GET['faculty_sub_id']);
$studentList = $studentsBySub->showBySubject($_GET['faculty_sub_id']);
$midtermComp = $period->showMidterm($selected_faculty_sub_id);
$finaltermComp = $period->showFinalterm($selected_faculty_sub_id);
?>

<!DOCTYPE html>
<html lang="en">
<?php
$title = $subject['sub_code'];
$home_page = 'active';
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
                    <a href="./index" class="bg-none d-flex align-items-center">
                        <i class='bx bx-chevron-left fs-2 brand-color'></i>
                    </a>
                    <div class="container-fluid d-flex justify-content-center">
                        <span class="fs-2 fw-bold h1 m-0 brand-color">Students List</span>
                    </div>
                </div>
            </div>

            <div class="m-4">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link text-dark active" id="nav-midterm-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-midterm" type="button" role="tab" aria-controls="nav-midterm"
                            aria-selected="true" onclick="updateURL('midterm')">Midterm</button>
                        <button class="nav-link text-dark" id="nav-finalterm-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-finalterm" type="button" role="tab" aria-controls="nav-finalterm"
                            aria-selected="false" onclick="updateURL('finalterm')">Final Term</button>
                    </div>
                </nav>

                <div class="tab-content py-4 px-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-midterm" role="tabpanel"
                        aria-labelledby="nav-midterm-tab">
                        <div class="content container-fluid mw-100 border rounded shadow p-3 position-relative">
                            <a href="./subject_setting?faculty_sub_id=<?= $selected_faculty_sub_id ?>"
                                name="edit_criteria"
                                class="btn-primary p-2 rounded position-absolute top-0 end-0 m-2"><i
                                    class='bx bxs-cog'></i>
                                Settings</a>

                            <div class="d-flex flex-column align-items-center">
                                <h3 class="brand-color"><?= ucwords($subject['sub_name']) ?></h3>
                                <h4><?= $subject['sub_code'] ?> (<?= $subject['yr_sec'] ?>)</h4>
                            </div>

                            <div class="d-flex flex-column align-items-end my-2">
                                <button class="btn btn-outline-secondary btn-add ms-3 brand-bg-color add-btn"
                                    type="button" data-bs-toggle="modal" data-bs-target="#addComponentModal"
                                    data-period="midterm">
                                    <i class='bx bx-plus-circle'></i>
                                </button>
                            </div>

                            <?php
                            // Pre-fetch component items for all components in $midtermComp
                            $componentItemsMap = [];
                            foreach ($midtermComp as $component) {
                                $componentId = $component['component_id'];
                                $componentItems = $comp_item->getItemById($componentId);
                                $componentItemsMap[$componentId] = $componentItems; // Store items for later use
                            }
                            ?>

                            <table id="student_table_midterm" class="table table-striped" style="width:125%">
                                <thead>
                                    <!-- Main Header Row -->
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Year & Section</th>
                                        <?php foreach ($midtermComp as $component): ?>
                                            <?php
                                            $componentId = $component['component_id'];
                                            $items = $componentItemsMap[$componentId]; // Use pre-fetched items
                                            $colspan = count($items);
                                            ?>
                                            <th colspan="<?= max(1, $colspan) ?>" class="text-center component-type-column">
                                                <?= ucwords($component['component_type']) ?>
                                            </th>
                                        <?php endforeach; ?>
                                    </tr>

                                    <!-- Subheader: Component Number & Date -->
                                    <tr>
                                        <th colspan="5"></th>
                                        <?php foreach ($midtermComp as $component): ?>
                                            <?php
                                            $componentId = $component['component_id'];
                                            $items = $componentItemsMap[$componentId]; // Use pre-fetched items
                                            if (!empty($items)) {
                                                foreach ($items as $item): ?>
                                                    <th class="text-center component-type-column">
                                                        <div style="font-size: 12px;"><?= "No. " . $item['component_no'] ?></div>
                                                        <div style="font-size: 12px; color: gray;">
                                                            <?= date('M d, Y', strtotime($item['component_date'])) ?>
                                                        </div>
                                                    </th>
                                                <?php endforeach;
                                            } else { ?>
                                                <th class="text-center component-type-column">N/A</th>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $counter = 1;
                                    foreach ($studentList as $student): ?>
                                        <tr>
                                            <td><?= $counter ?></td>
                                            <td>
                                                <a
                                                    href="./edit_grades?faculty_sub_id=<?= $selected_faculty_sub_id ?>&grades_id=<?= $student['grades_id'] ?>&active_period=<?= $_GET['active_period'] ?? 'midterm' ?>">
                                                    <?= $student['student_id'] ?>
                                                </a>
                                            </td>
                                            <td><?= ucwords($student['fullName']) ?></td>
                                            <td><?= $student['email'] ?></td>
                                            <td><?= $student['year_section'] ?></td>

                                            <?php foreach ($midtermComp as $component): ?>
                                                <?php
                                                $componentId = $component['component_id'];
                                                $items = $componentItemsMap[$componentId]; // Use pre-fetched items
                                                if (!empty($items)) {
                                                    foreach ($items as $item):
                                                        $scoreData = $scores->getAllScoreByItemStud($student['grades_id'], $item['items_id']);
                                                        if (!empty($scoreData)) {
                                                            foreach ($scoreData as $score): ?>
                                                                <td class="text-center">
                                                                    <?= htmlspecialchars($score['score']) . '/' . $item['component_quantity'] ?>
                                                                </td>
                                                            <?php endforeach;
                                                        } else { ?>
                                                            <td class="text-center">0/<?= $item['component_quantity'] ?></td>
                                                        <?php }
                                                    endforeach;
                                                } else { ?>
                                                    <td class="text-center">-</td>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        </tr>
                                        <?php
                                        $counter++;
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-finalterm" role="tabpanel" aria-labelledby="nav-finalterm-tab">
                        <div class="content container-fluid mw-100 border rounded shadow p-3 position-relative">
                            <a href="./subject_setting?faculty_sub_id=<?= $selected_faculty_sub_id ?>"
                                name="edit_criteria"
                                class="btn-primary p-2 rounded position-absolute top-0 end-0 m-2"><i
                                    class='bx bxs-cog'></i>
                                Settings</a>

                            <div class="d-flex flex-column align-items-center">
                                <h3 class="brand-color"><?= ucwords($subject['sub_name']) ?></h3>
                                <h4><?= $subject['sub_code'] ?> (<?= $subject['yr_sec'] ?>)</h4>
                            </div>

                            <div class="d-flex flex-column align-items-end my-2">
                                <button class="btn btn-outline-secondary btn-add ms-3 brand-bg-color add-btn"
                                    type="button" data-bs-toggle="modal" data-bs-target="#addComponentModal"
                                    data-period="finalterm">
                                    <i class='bx bx-plus-circle'></i>
                                </button>
                            </div>

                            <?php
                            // Pre-fetch component items for all components in $midtermComp
                            $componentItemsMap = [];
                            foreach ($finaltermComp as $component) {
                                $componentId = $component['component_id'];
                                $componentItems = $comp_item->getItemById($componentId);
                                $componentItemsMap[$componentId] = $componentItems; // Store items for later use
                            }
                            ?>

                            <table id="student_table_finalterm" class="table table-striped" style="width:125%">
                                <thead>
                                    <!-- Main Header Row -->
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Year & Section</th>
                                        <?php foreach ($finaltermComp as $component): ?>
                                            <?php
                                            $componentId = $component['component_id'];
                                            $items = $componentItemsMap[$componentId]; // Use pre-fetched items
                                            $colspan = count($items);
                                            ?>
                                            <th colspan="<?= max(1, $colspan) ?>" class="text-center component-type-column">
                                                <?= ucwords($component['component_type']) ?>
                                            </th>
                                        <?php endforeach; ?>
                                    </tr>

                                    <!-- Subheader: Component Number & Date -->
                                    <tr>
                                        <th colspan="5"></th>
                                        <?php foreach ($finaltermComp as $component): ?>
                                            <?php
                                            $componentId = $component['component_id'];
                                            $items = $componentItemsMap[$componentId]; // Use pre-fetched items
                                            if (!empty($items)) {
                                                foreach ($items as $item): ?>
                                                    <th class="text-center component-type-column">
                                                        <div style="font-size: 12px;"><?= "No. " . $item['component_no'] ?></div>
                                                        <div style="font-size: 12px; color: gray;">
                                                            <?= date('M d, Y', strtotime($item['component_date'])) ?>
                                                        </div>
                                                    </th>
                                                <?php endforeach;
                                            } else { ?>
                                                <th class="text-center component-type-column">N/A</th>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $counter = 1;
                                    foreach ($studentList as $student): ?>
                                        <tr>
                                            <td><?= $counter ?></td>
                                            <td>
                                                <a
                                                    href="./edit_grades?faculty_sub_id=<?= $selected_faculty_sub_id ?>&grades_id=<?= $student['grades_id'] ?>&active_period=<?= $_GET['active_period'] ?? 'midterm' ?>">
                                                    <?= $student['student_id'] ?>
                                                </a>
                                            </td>
                                            <td><?= ucwords($student['fullName']) ?></td>
                                            <td><?= $student['email'] ?></td>
                                            <td><?= $student['year_section'] ?></td>

                                            <?php foreach ($finaltermComp as $component): ?>
                                                <?php
                                                $componentId = $component['component_id'];
                                                $items = $componentItemsMap[$componentId]; // Use pre-fetched items
                                                if (!empty($items)) {
                                                    foreach ($items as $item):
                                                        $scoreData = $scores->getAllScoreByItemStud($student['grades_id'], $item['items_id']);
                                                        if (!empty($scoreData)) {
                                                            foreach ($scoreData as $score): ?>
                                                                <td class="text-center">
                                                                    <?= htmlspecialchars($score['score']) . '/' . $item['component_quantity'] ?>
                                                                </td>
                                                            <?php endforeach;
                                                        } else { ?>
                                                            <td class="text-center">0/<?= $item['component_quantity'] ?></td>
                                                        <?php }
                                                    endforeach;
                                                } else { ?>
                                                    <td class="text-center">-</td>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        </tr>
                                        <?php
                                        $counter++;
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <!-- Modal for Adding Component -->
        <div class="modal fade" id="addComponentModal" tabindex="-1" aria-labelledby="addComponentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addComponentModalLabel">Add Column</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <?php
                                $facultySubId = $selected_faculty_sub_id;

                                // Check which tab is currently selected
                                $activePeriod = isset($_GET['active_period']) ? $_GET['active_period'] : 'midterm';
                                $selectedComponents = ($activePeriod === 'finalterm') ? $finaltermComp : $midtermComp;

                                if (!empty($selectedComponents)):
                                    foreach ($selectedComponents as $component):
                                        ?>
                                        <div class="col-6">
                                            <a href="./add_component_items?faculty_sub_id=<?= $facultySubId ?>&component_id=<?= $component['component_id'] ?>"
                                                class="d-flex align-items-center justify-content-center brand-bg-color w-100 p-3 mb-2 rounded">
                                                <?= ucwords($component['component_type']) ?>
                                            </a>
                                        </div>
                                        <?php
                                    endforeach;
                                else:
                                    ?>
                                    <div class="col-12 text-center">
                                        <p>No criteria available</p>
                                        <a href="./subject_setting?faculty_sub_id=<?= $facultySubId ?>" name="edit_criteria"
                                            class="btn btn-primary p-2 rounded">
                                            Add Criteria
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="./js/main.js"></script>
    <script>
        $(document).ready(function () {
            $('#student_table_midterm').DataTable({
                pageLength: 5,
                scrollX: true,
                lengthChange: false,
                columnDefs: [{
                    targets: [1, 2, 3, 4],
                    orderable: true,
                }]
            });

            $('#student_table_finalterm').DataTable({
                pageLength: 5,
                scrollX: true,
                lengthChange: false,
                columnDefs: [{
                    targets: [1, 2, 3, 4],
                    orderable: true,
                }]
            });
        });


        function updateURL(period) {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('active_period', period);
            window.location.href = window.location.pathname + '?' + urlParams.toString();
        }

        document.addEventListener('DOMContentLoaded', function () {
            function saveActiveTab(tabId) {
                localStorage.setItem('activeTab', tabId);
            }

            function restoreActiveTab() {
                const activeTabId = localStorage.getItem('activeTab');
                if (activeTabId) {
                    const urlParams = new URLSearchParams(window.location.search);
                    const currentPeriod = urlParams.get('active_period');

                    if (activeTabId === "nav-midterm-tab" && currentPeriod !== 'midterm') {
                        urlParams.set('active_period', 'midterm');
                        window.location.replace(window.location.pathname + '?' + urlParams.toString());
                        return; // End function to prevent further execution
                    } else if (activeTabId === "nav-finalterm-tab" && currentPeriod !== 'finalterm') {
                        urlParams.set('active_period', 'finalterm');
                        window.location.replace(window.location.pathname + '?' + urlParams.toString());
                        return; // End function to prevent further execution
                    }

                    // If URL is already correct, just activate the tab
                    const tabTrigger = new bootstrap.Tab(document.querySelector(`#${activeTabId}`));
                    tabTrigger.show();
                }
            }

            const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const tabId = this.getAttribute('id');
                    saveActiveTab(tabId);
                });
            });

            // Restore the active tab on page load
            restoreActiveTab();
        });

    </script>
</body>

</html>