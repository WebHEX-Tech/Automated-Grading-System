<?php

require_once 'database.php';

class Faculty_Subjects
{

    public $faculty_sub_id;
    public $sched_id;
    public $curr_id;
    public $yr_sec;
    public $no_students;
    public $lec_days;
    public $lab_days;
    public $lec_time;
    public $lab_time;
    public $lec_room;
    public $lab_room;
    public $lec_units;
    public $lab_units;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function add()
    {
        $sql = "INSERT INTO faculty_subjects (sched_id, curr_id, yr_sec, no_students, lec_days, lab_days, lec_time, lab_time, lec_room, lab_room, lec_units, lab_units) 
            VALUES ('$this->sched_id', '$this->curr_id', '$this->yr_sec', '$this->no_students', '$this->lec_days', '$this->lab_days', '$this->lec_time', '$this->lab_time', '$this->lec_room', '$this->lab_room', '$this->lec_units', '$this->lab_units')";

        $db = $this->db->connect();
        if ($db->exec($sql)) {
            return $db->lastInsertId(); // Return last inserted ID
        } else {
            return false;
        }
    }


    function show()
    {
        $sql = "SELECT * FROM faculty_subjects ORDER BY faculty_sub_id ASC;";

        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }
    function showByFaculty($sched_id)
    {
        $sql = "SELECT fs.*, ct.sub_code, ct.sub_name, ct.sub_prerequisite FROM faculty_subjects fs
            LEFT JOIN curr_table ct ON fs.curr_id = ct.curr_id
            WHERE sched_id = :sched_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':sched_id', $sched_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function fetch($faculty_sub_id)
    {
        $sql = "SELECT * FROM faculty_subjects WHERE faculty_sub_id = :faculty_sub_id;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':faculty_sub_id', $faculty_sub_id);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function getProf($faculty_sub_id)
    {
        $sql = "SELECT fs.*, c.sub_code, c.sub_name FROM faculty_subjects fs
                INNER JOIN curr_table c ON fs.curr_id = c.curr_id
                WHERE faculty_sub_id = :faculty_sub_id;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':faculty_sub_id', $faculty_sub_id);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function searchByDeptName($keyword)
    {
        $sql = "SELECT * FROM college_department_table WHERE department_name LIKE :keyword;";
        $query = $this->db->connect()->prepare($sql);
        $keyword = "%$keyword%";
        $query->bindParam(':keyword', $keyword);

        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }
    function getByUser($emp_id)
    {
        $sql = "SELECT fs.*, ct.sub_code, ct.sub_name, ct.sub_prerequisite, sch.school_yr, s.semester
                FROM faculty_subjects fs
                INNER JOIN curr_table ct ON fs.curr_id = ct.curr_id
                INNER JOIN faculty_schedule sch ON fs.sched_id = sch.sched_id
                INNER JOIN profiling_table p ON sch.profiling_id = p.profiling_id
                INNER JOIN semester s ON sch.semester = s.semester_id
                WHERE p.emp_id = :emp_id";

        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':emp_id', $emp_id);
        $data = null;

        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
        }

        return $data;
    }
    public function delete($faculty_sub_id)
    {
        $query = "DELETE FROM faculty_subjects WHERE faculty_sub_id = :faculty_sub_id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':faculty_sub_id', $faculty_sub_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

?>