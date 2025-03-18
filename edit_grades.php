<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
    header('location: ./login.php');
    exit();
}

require_once './classes/students.class.php';
require_once './classes/component.class.php';
require_once './classes/component_items.class.php';
require_once './classes/component_scores.class.php';
require_once './classes/grades.class.php';
require_once './classes/period.class.php';

$students = new Students();
$components = new SubjectComponents();
$comp_items = new ComponentItems();
$scores = new ComponentScores();
$period = new Periods();
$grades = new Grades();

$faculty_sub_id = $_GET['faculty_sub_id'] ?? null;
$grades_id = $_GET['grades_id'] ?? null;
$active_period = $_GET['active_period'] ?? null;
$grade_period = '';

if ($active_period === 'midterm') {
    $grade_period = 'Midterm';
} else {
    $grade_period = 'Final Term';
}

$student = $grades->showById($grades_id);
$gradingComponents = ($active_period === 'finalterm') ? $period->showFinalterm($faculty_sub_id) : $period->showMidterm($faculty_sub_id);
$midtermGrade = $period->showMidterm($faculty_sub_id);
$error_message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_grades'])) {
    foreach ($_POST['grades'] as $component_id => $items) {
        foreach ($items as $items_id => $score) {
            $score = is_numeric($score) ? floatval($score) : 0; // Ensure score is a valid number

            if ($scores->scoreExists($grades_id, $items_id)) {
                $scores->updateScore($grades_id, $items_id, $score);
            } else {
                $scores->add($grades_id, $items_id, $score);
            }

        }
    }
    $message = 'Grades updated successfully!';
    $success = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<?php
$title = 'Edit Grades';
$home_page = 'active';
include './includes/head.php';
?>

<body>
    <div class="home">
        <div class="side">
            <?php require_once('./includes/sidepanel.php'); ?>
        </div>
        <main>
            <div class="header">
                <?php require_once('./includes/header.php'); ?>
            </div>

            <div class="flex-md-nowrap p-1 title_page shadow" style="background-color: whitesmoke;">
                <div class="d-flex align-items-center">
                    <a href="./subject_students.php?faculty_sub_id=<?= $faculty_sub_id ?>" class="bg-none"><i
                            class='bx bx-chevron-left fs-2 brand-color'></i></a>
                    <div class="container-fluid d-flex justify-content-center">
                        <span class="fs-2 h1 m-0">Edit Grades</span>
                    </div>
                </div>
            </div>

            <div class="m-5 position-relative">
                <form action="#" method="post">
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class='bx bx-check-circle'></i> <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <h3>Student Information</h3>
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col">
                            <div class="mb-3 ms-5">
                                <label class="form-label">Student ID</label>
                                <input type="text" class="form-control"
                                    value="<?= htmlspecialchars($student['student_id']) ?>" readonly>
                            </div>
                            <div class="mb-3 ms-5">
                                <label class="form-label">Student Name</label>
                                <input type="text" class="form-control"
                                    value="<?= htmlspecialchars($student['fullName']) ?>" readonly>
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3 ms-5">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control"
                                    value="<?= htmlspecialchars($student['email']) ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <hr style="color:#952323; padding: 1px;">

                    <?php foreach ($gradingComponents as $index => $component): ?>
                        <div class="component-container">
                            <h4 class="my-4 text-primary"><?= htmlspecialchars($component['component_type']) ?>
                                (<?= htmlspecialchars($component['weight']) ?>%)</h4>

                            <?php
                            $component_items = $comp_items->getItemById($component['component_id']);
                            foreach ($component_items as $item):
                                // $current_grade = $grades->getGrade($student['student_id'], $component['component_id'], $item['component_no']);
                                ?>
                                <div class="row mb-4">
                                    <div class="col-md-1">
                                        <p class="title_page">
                                            <?= $component['component_type'] . ' No.' . $item['component_no'] ?>
                                        </p>
                                        <p>(<?= date('M d, Y', strtotime($item['component_date'])) ?>)</p>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label">Total</label>
                                        <input type="number" style="width: 120px;" id="total" class="form-control"
                                            value="<?= htmlspecialchars($item['component_quantity']) ?>" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label">Score</label>
                                        <input type="number" style="width: 120px;" id="score" class="form-control score-input"
                                            name="grades[<?= $component['component_id'] ?>][<?= $item['items_id'] ?>]"
                                            value="<?= htmlspecialchars($scores->getScoreByItemStud($grades_id, $item['items_id']) ?: 0) ?>"
                                            data-total="<?= $item['component_quantity'] ?>">
                                    </div>
                                </div>

                            <?php endforeach; ?>

                            <div class="row mt-5">
                                <div class="col-md-1">
                                    <label class="form-label">Average</label>
                                    <input type="text" style="width: 120px;" class="form-control average-score"
                                        value="<?= round($scores->calculateAverageByComponent($grades_id, $component['component_id']) ?: 0, 2) ?>%"
                                        readonly>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Weight</label>
                                    <input type="text" style="width: 120px;" class="form-control weighted-score"
                                        value="<?= $_POST['weighted_score'] ?? round($scores->calculateWeightByComponent($grades_id, $component['component_id']) ?: 0, 2) ?>%"
                                        readonly>
                                </div>
                            </div>

                        </div>
                        <hr class="mb-5">
                    <?php endforeach; ?>
                    <div style="margin-bottom: 10rem;"></div>
                    <div class="d-flex justify-content-between align-items-center mt-4 gap-2 sticky-btn">
                        <div class="d-flex flex-row gap-3 ms-5">
                            <?php
                            $avgGrade = 0;
                            $midtermAvg = 0;
                            foreach ($gradingComponents as $component) {
                                $avgGrade += $scores->calculateWeightByComponent($grades_id, $component['component_id']) ?: 0;
                            }
                            foreach ($midtermGrade as $component) {
                                $midtermAvg += $scores->calculateWeightByComponent($grades_id, $component['component_id']) ?: 0;
                            }
                            $avgGrade = round($avgGrade, 2);
                            $midtermAvg = round($midtermAvg, 2);

                            function getNumericalRating($grade)
                            {
                                if ($grade >= 97)
                                    return 1.0;
                                elseif ($grade >= 94)
                                    return 1.25;
                                elseif ($grade >= 91)
                                    return 1.5;
                                elseif ($grade >= 88)
                                    return 1.75;
                                elseif ($grade >= 85)
                                    return 2.0;
                                elseif ($grade >= 82)
                                    return 2.25;
                                elseif ($grade >= 79)
                                    return 2.5;
                                elseif ($grade >= 76)
                                    return 2.75;
                                elseif ($grade >= 75)
                                    return 3.0;
                                else
                                    return 5.0;
                            }

                            $numericalRating = getNumericalRating(($midtermAvg + $avgGrade)/2);
                            ?>
                            <?php if ($active_period !== 'midterm'): ?>
                                <div>
                                    <label class="form-label" style="color: #952323;">Midterm Grade</label>
                                    <input type="text" style="width: 120px;" class="form-control average-score"
                                        value="<?= $midtermAvg ?>%" readonly>
                                </div>
                            <?php endif; ?>
                            <div>
                                <label class="form-label" style="color: #952323;"><?= $grade_period ?> Grade</label>
                                <input type="text" style="width: 120px;" class="form-control average-score"
                                    value="<?= $avgGrade ?>%" readonly>
                            </div>
                            <?php if ($active_period !== 'midterm'): ?>
                                <div style="margin-left: 3em;">
                                    <label class="form-label" style="color: #952323;">Point Eqv.(Expected)</label>
                                    <input type="text" style="width: 120px;" class="form-control weighted-score"
                                        value="<?= number_format((float) $numericalRating, 2, '.', '') ?>" readonly>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <a href="subject_students.php?faculty_sub_id=<?= $faculty_sub_id ?>" type="button"
                                class="btn btn-secondary">Cancel</a>
                            <button type="button" class="btn brand-bg-color" id="saveChangesBtn"><i
                                    class='bx bxs-save me-2'></i>Save
                                Changes</button>
                        </div>
                    </div>

                    <div class="modal fade" id="saveConfirmationModal" tabindex="-1"
                        aria-labelledby="saveConfirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="saveConfirmationModalLabel">Confirm Save</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to save these changes?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" name="edit_grades" id="edit_grades"
                                        class="btn btn-primary">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="./js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".score-input").forEach(input => {
                input.addEventListener("input", function () {
                    let maxScore = parseFloat(this.dataset.total) || 0;
                    let enteredScore = parseFloat(this.value) || 0;

                    if (enteredScore > maxScore) {
                        this.value = maxScore;
                        alert(`Score cannot exceed ${maxScore}`);
                    } else if (enteredScore < 0) {
                        this.value = 0;
                        alert("Score cannot be less than 0");
                    }

                    const componentContainer = this.closest(".component-container");
                    updateComponentCalculations(componentContainer);
                });
            });
        });

        document.getElementById('saveChangesBtn').addEventListener('click', function () {
            let saveModal = new bootstrap.Modal(document.getElementById('saveConfirmationModal'));
            saveModal.show();
        });

        function updateComponentCalculations(componentContainer) {
            let totalScore = 0, totalMaxScore = 0, count = 0;

            componentContainer.querySelectorAll("#score").forEach(input => {
                let score = parseFloat(input.value) || 0;
                let maxScore = parseFloat(input.closest(".row").querySelector("#total").value) || 1;

                if (score > maxScore) {
                    input.value = maxScore;
                    alert(`Score cannot exceed ${maxScore}`);
                } else if (score < 0) {
                    input.value = 0;
                    alert("Score cannot be less than 0");
                }

                totalScore += score;
                totalMaxScore += maxScore;
                count++;
            });

            let avgScore = count > 0 ? (totalScore / totalMaxScore) * 100 : 0;
            let weight = parseFloat(componentContainer.dataset.weight) || 0;
            let weightedScore = (avgScore / 100) * weight;

            componentContainer.querySelector(".average-score").value = avgScore.toFixed(2);
            componentContainer.querySelector(".weighted-score").value = weightedScore.toFixed(2) + "%";
        }


        <?php if ($success): ?>
            setTimeout(function () {
                window.location.href = './edit_grades?faculty_sub_id=<?= $faculty_sub_id ?>&grades_id=<?= $grades_id ?>&active_period=<?= $active_period ?>';
            }, 1500);
        <?php endif; ?>
    </script>
</body>

</html>