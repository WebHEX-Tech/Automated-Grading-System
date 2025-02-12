<?php

require_once 'database.php';

class Sub_Students
{
    public $student_data_id;
    public $student_id;
    public $faculty_sub_id;
    public $student_firstname;
    public $student_middlename;
    public $student_lastname;
    public $email;
    public $year_section;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function add()
    {
        $sql = "INSERT INTO subject_students (student_id, faculty_sub_id, student_firstname, student_middlename, student_lastname, email, year_section) VALUES
        (:student_id, :faculty_sub_id, :student_firstname, :student_middlename, :student_lastname, :email, :year_section);";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_id', $this->student_id);
        $query->bindParam(':faculty_sub_id', $this->faculty_sub_id);
        $query->bindParam(':student_firstname', $this->student_firstname);
        $query->bindParam(':student_middlename', $this->student_middlename);
        $query->bindParam(':student_lastname', $this->student_lastname);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':year_section', $this->year_section);

        return $query->execute();
    }

    function show()
    {
        $sql = "SELECT * FROM subject_students ORDER BY student_lastname ASC;";

        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function getStudentById($student_id)
    {
        $sql = "SELECT * FROM subject_students WHERE student_data_id = :student_data_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_data_id', $student_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function showBySubject($faculty_sub_id)
    {
        $sql = "SELECT *,
                    CONCAT(
                        student_lastname, ', ',
                        student_firstname,
                        IF(student_middlename IS NOT NULL AND student_middlename != '', CONCAT(' ', LEFT(student_middlename, 1)), ''),
                        '.'
                    ) AS fullName
                FROM subject_students
                WHERE faculty_sub_id = :faculty_sub_id
                ORDER BY student_lastname ASC;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':faculty_sub_id', $faculty_sub_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function searchByStudentName($keyword)
    {
        $sql = "SELECT * FROM subject_students WHERE student_firstname LIKE :keyword OR student_lastname LIKE :keyword;";
        $query = $this->db->connect()->prepare($sql);
        $keyword = "%$keyword%";
        $query->bindParam(':keyword', $keyword);

        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    public function edit()
    {
        $sql = "UPDATE subject_students SET
                    student_firstname = :firstname,
                    student_middlename = :middlename,
                    student_lastname = :lastname,
                    email = :email,
                    year_section = :year_section
                WHERE student_data_id = :student_data_id";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':student_data_id', $this->student_data_id, PDO::PARAM_INT);
        $query->bindParam(':firstname', $this->student_firstname, PDO::PARAM_STR);
        $query->bindParam(':middlename', $this->student_middlename, PDO::PARAM_STR);
        $query->bindParam(':lastname', $this->student_lastname, PDO::PARAM_STR);
        $query->bindParam(':email', $this->email, PDO::PARAM_STR);
        $query->bindParam(':year_section', $this->year_section, PDO::PARAM_STR);

        return $query->execute();
    }

    public function delete($student_data_id)
    {
        $query = "DELETE FROM subject_students WHERE student_data_id = :student_data_id";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(':student_data_id', $student_data_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

?>