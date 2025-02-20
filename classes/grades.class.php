<?php

require_once 'database.php';

class Grades
{
    public $student_data_id;
    public $faculty_sub_id;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function add()
    {
        $sql = "INSERT INTO student_grades (student_data_id, faculty_sub_id) VALUES
        (:student_data_id, :faculty_sub_id);";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_data_id', $this->student_data_id);
        $query->bindParam(':faculty_sub_id', $this->faculty_sub_id);

        return $query->execute();
    }

    function show()
    {
        $sql = "SELECT * FROM student_grades ORDER BY student_data_id ASC;";

        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function getGradeById($student_data_id)
    {
        $sql = "SELECT * FROM student_grades WHERE student_data_id = :student_data_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_data_id', $student_data_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }
    function getStudentByIdAndSub($student_data_id, $faculty_sub_id)
    {
        $sql = "SELECT * FROM student_grades WHERE student_data_id = :student_data_id AND faculty_sub_id = :faculty_sub_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_data_id', $student_data_id);
        $query->bindParam(':faculty_sub_id', $faculty_sub_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }
    function showBySubject($faculty_sub_id)
    {
        $sql = "SELECT g.*,
            CONCAT(
                s.student_lastname,
                IF(s.suffix IS NOT NULL AND s.suffix != '', CONCAT(' ', s.suffix), ''),
                ', ',
                s.student_firstname,
                IF(s.student_middlename IS NOT NULL AND s.student_middlename != '', CONCAT(' ', LEFT(s.student_middlename, 1)), ''),
                '.'
            ) AS fullName,
            s.email,
            s.year_section,
            s.student_id
        FROM student_grades g
        INNER JOIN students s ON g.student_data_id = s.student_data_id
        WHERE faculty_sub_id = :faculty_sub_id
        ORDER BY s.student_lastname ASC;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':faculty_sub_id', $faculty_sub_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function showById($grades_id)
    {
        $sql = "SELECT g.*,
            CONCAT(
                s.student_lastname,
                IF(s.suffix IS NOT NULL AND s.suffix != '', CONCAT(' ', s.suffix), ''),
                ', ',
                s.student_firstname,
                IF(s.student_middlename IS NOT NULL AND s.student_middlename != '', CONCAT(' ', LEFT(s.student_middlename, 1)), ''),
                '.'
            ) AS fullName,
            s.email,
            s.year_section,
            s.student_id
        FROM student_grades g
        INNER JOIN students s ON g.student_data_id = s.student_data_id
        WHERE grades_id = :grades_id
        ORDER BY s.student_lastname ASC;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':grades_id', $grades_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    public function delete($grades_id)
    {
        $query = "DELETE FROM student_grades WHERE grades_id = :grades_id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':grades_id', $grades_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

?>