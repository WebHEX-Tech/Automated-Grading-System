<?php

require_once 'database.php';

class Faculty_Subjects
{

    public $faculty_sub_id;
    public $sched_id;
    public $sub_code;
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
        $sql = "INSERT INTO faculty_subjects (sched_id, sub_code, yr_sec, no_students, lec_days, lab_days, lec_time, lab_time, lec_room, lab_room, lec_units, lab_units) 
              VALUES (:sched_id, :sub_code, :yr_sec, :no_students, :lec_days, :lab_days, :lec_time, :lab_time, :lec_room, :lab_room, :lec_units, :lab_units)";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':sched_id', $this->sched_id);
        $query->bindParam(':sub_code', $this->sub_code);
        $query->bindParam(':yr_sec', $this->yr_sec);
        $query->bindParam(':no_students', $this->no_students);
        $query->bindParam(':lec_days', $this->lec_days);
        $query->bindParam(':lab_days', $this->lab_days);
        $query->bindParam(':lec_time', $this->lec_time);
        $query->bindParam(':lab_time', $this->lab_time);
        $query->bindParam(':lec_room', $this->lec_room);
        $query->bindParam(':lab_room', $this->lab_room);
        $query->bindParam(':lec_units', $this->lec_units);
        $query->bindParam(':lab_units', $this->lab_units);

        if ($query->execute()) {
            return true;
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
        $sql = "SELECT fs.*, ct.sub_name, ct.sub_prerequisite FROM faculty_subjects fs
            LEFT JOIN curr_table ct ON fs.sub_code = ct.sub_code
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
    public function delete($faculty_sub_id)
    {
        $query = "DELETE FROM faculty_subjects WHERE faculty_sub_id = :faculty_sub_id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':faculty_sub_id', $faculty_sub_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

?>