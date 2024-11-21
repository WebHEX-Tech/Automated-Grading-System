<?php 

require_once 'database.php';

Class Department {

  public $department_id;
  public $department_name;

  protected $db;

  function __construct() {
    $this->db = new Database();
  }

  // function add() {
  //   $sql = "INSERT INTO college_department_table (department_id, department_name) VALUES 
  //   (:department_id, :department_name);";

  //   $query=$this->db->connect()->prepare($sql);
  //   $query->bindParam(':department_id', $this->department_id);
  //   $query->bindParam(':department_name', $this->department_name);
    
  //   if($query->execute()){
  //     return true;
  //   }
  //   else{
  //     return false;
  //   }  
  // }

  function show() {
    $sql = "SELECT * FROM college_department_table ORDER BY department_id ASC;";
    
    $query = $this->db->connect()->prepare($sql);
    $data = null;
    if($query->execute()){
      $data = $query->fetchAll();
    }
    return $data;
  }


}

?>