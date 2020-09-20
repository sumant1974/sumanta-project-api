<?php
// 'Student' object
class Student{
 
    // database connection and table name
    private $conn;
    private $table_name = "edb_students";
 
    // object properties
    
    public $edbs_id;
    public $edb_id;
    public $edbs_firstname;
    public $edbs_lastname;
    public $edbs_mobile;
    public $edbs_email;
    public $edbs_alternate_mobile;
    public $edbs_alternate_email;
    public $course_id;
    public $inst_id;
    public $partner_id;
     public $allstudents;
     public $studentcount;
     public $errmsg;
    // constructor
    public function __construct($db){
        $this->conn = $db;
		//$allusers=array();
    }
 
// create() method will be here

// create new user record
function create(){
 
    // insert query
    $query = "INSERT INTO " . $this->table_name . "
            SET
                edb_id = :edb_id,
                edbs_firstname = :edbs_firstname,
                edbs_lastname = :edbs_lastname,
                edbs_mobile = :edbs_mobile,
                edbs_alternate_mobile = :edbs_alternate_mobile,
                edbs_alternate_email = :edbs_alternate_email,
                edbs_email = :edbs_email"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	
    $this->edb_id=htmlspecialchars(strip_tags($this->edb_id));
    $this->edbs_firstname=htmlspecialchars(strip_tags($this->edbs_firstname));
    $this->edbs_lastname=htmlspecialchars(strip_tags($this->edbs_lastname));
    $this->edbs_mobile=htmlspecialchars(strip_tags($this->edbs_mobile));
    $this->edbs_alternate_mobile=htmlspecialchars(strip_tags($this->edbs_alternate_mobile));
    $this->edbs_alternate_email=htmlspecialchars(strip_tags($this->edbs_alternate_email));
    $this->edbs_email=htmlspecialchars(strip_tags($this->edbs_email));
     
    // bind the values
	
	$stmt->bindParam(':edb_id',$this->edb_id);
    $stmt->bindParam(':edbs_firstname', $this->edbs_firstname);
    $stmt->bindParam(':edbs_lastname', $this->edbs_lastname);
    $stmt->bindParam(':edbs_mobile', $this->edbs_mobile);
    $stmt->bindParam(':edbs_alternate_mobile', $this->edbs_alternate_mobile);
    $stmt->bindParam(':edbs_alternate_email', $this->edbs_alternate_email);
    $stmt->bindParam(':edbs_email', $this->edbs_email);

// echo "all set";
    // execute the query, also check if query was successful
    if($stmt->execute()){
	//	echo "insert OK";
        return true;
    }
    //echo implode(",",$stmt->errorInfo());
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
 

// update() method will be here
public function update(){
 
    $query = "UPDATE " . $this->table_name . "
            SET
                edb_id = :edb_id,
                edbs_firstname = :edbs_firstname,
                edbs_lastname = :edbs_lastname,
                edbs_mobile = :edbs_mobile,
                edbs_alternate_mobile = :edbs_alternate_mobile,
                edbs_alternate_email = :edbs_alternate_email,
                edbs_email = :edbs_email
            WHERE
                edbs_id=:edbs_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->edb_id=htmlspecialchars(strip_tags($this->edb_id));
    $this->edbs_firstname=htmlspecialchars(strip_tags($this->edbs_firstname));
    $this->edbs_lastname=htmlspecialchars(strip_tags($this->edbs_lastname));
    $this->edbs_mobile=htmlspecialchars(strip_tags($this->edbs_mobile));
    $this->edbs_alternate_mobile=htmlspecialchars(strip_tags($this->edbs_alternate_mobile));
    $this->edbs_alternate_email=htmlspecialchars(strip_tags($this->edbs_alternate_email));
    $this->edbs_email=htmlspecialchars(strip_tags($this->edbs_email));
 
    // bind the values from the form
    $stmt->bindParam(':edb_id',$this->edb_id);
    $stmt->bindParam(':edbs_firstname', $this->edbs_firstname);
    $stmt->bindParam(':edbs_lastname', $this->edbs_lastname);
    $stmt->bindParam(':edbs_mobile', $this->edbs_mobile);
    $stmt->bindParam(':edbs_alternate_mobile', $this->edbs_alternate_mobile);
    $stmt->bindParam(':edbs_alternate_email', $this->edbs_alternate_email);
    $stmt->bindParam(':edbs_email', $this->edbs_email);
 
    
    // unique ID of record to be edited
    $this->edbs_id=htmlspecialchars(strip_tags($this->edbs_id));
    $stmt->bindParam(':edbs_id', $this->edbs_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getallstudents(){
 
    // query to check if email exists
    $query = "SELECT `edbs_id`,`edb_id`,`edbs_firstname`,`edbs_lastname`,`edbs_mobile`,`edbs_email`,`edbs_alternate_mobile`,`edbs_alternate_email` FROM " . $this->table_name;
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allstudents=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getcstudents(){
 
    // query to check if email exists
    $query = "SELECT `course_id`,`edbs_id`,`edb_id`,`edbs_firstname`,`edbs_lastname`,`edbs_mobile`,`edbs_email`,`edbs_alternate_mobile`,`edbs_alternate_email` FROM `cstudents` where course_id=:course_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );

    // unique ID of record to be edited
    $this->course_id=htmlspecialchars(strip_tags($this->course_id));
    $stmt->bindParam(':course_id', $this->course_id);
 

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allstudents=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getistudents(){
 
    // query to check if email exists
    $query = "SELECT `inst_id`,`edbs_id`,`edb_id`,`edbs_firstname`,`edbs_lastname`,`edbs_mobile`,`edbs_email`,`edbs_alternate_mobile`,`edbs_alternate_email` FROM `istudents` where inst_id=:inst_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );

    // unique ID of record to be edited
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $stmt->bindParam(':inst_id', $this->inst_id);
 

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allstudents=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getpstudents(){
 
    // query to check if email exists
    $query = "SELECT `partner_id`,`course_id`,`edbs_id`,`edb_id`,`edbs_firstname`,`edbs_lastname`,`edbs_mobile`,`edbs_email`,`edbs_alternate_mobile`,`edbs_alternate_email` FROM `pstudents` where partner_id=:partner_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );

    // unique ID of record to be edited
    $this->partner_id=htmlspecialchars(strip_tags($this->partner_id));
    $stmt->bindParam(':partner_id', $this->partner_id);
 

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allstudents=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getedbstudents(){
 
    // query to check if email exists
    $query = "SELECT `edbs_id`,`edb_id`,`edbs_firstname`,`edbs_lastname`,`edbs_mobile`,`edbs_email`,`edbs_alternate_mobile`,`edbs_alternate_email` FROM " . $this->table_name . " WHERE `edb_id`=:edb_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // unique ID of record to be edited
    $this->edb_id=htmlspecialchars(strip_tags($this->edb_id));
    $stmt->bindParam(':edb_id', $this->edb_id);
 

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allstudents=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getedbstudent(){
 
    // query to check if email exists
    $query = "SELECT `edbs_id`,`edb_id`,`edbs_firstname`,`edbs_lastname`,`edbs_mobile`,`edbs_email`,`edbs_alternate_mobile`,`edbs_alternate_email` FROM " . $this->table_name . " WHERE `edbs_id`=:edbs_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->edbs_id=htmlspecialchars(strip_tags($this->edbs_id));
    $stmt->bindParam(':edbs_id', $this->edbs_id);

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->edb_id=$row['edb_id'];
        $this->edbs_firstname=$row['edbs_firstname'];
        $this->edbs_lastname=$row['edbs_lastname'];
        $this->edbs_mobile=$row['edbs_mobile'];
        $this->edbs_alternate_mobile=$row['edbs_alternate_mobile'];
        $this->edbs_alternate_email=$row['edbs_alternate_email'];
        $this->edbs_email=$row['edbs_email'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getstudentcount(){

     // query to check if email exists
     $query = "SELECT count(*) as studentcount FROM " . $this->table_name;
 
     // prepare the query
     $stmt = $this->conn->prepare( $query );
 
     $stmt->execute();
  
     // get number of rows
     $num = $stmt->rowCount();
  
     if($num>0){
  
         // get record details / values
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->studentcount=$row['studentcount'];
         //echo json_encode($allusers);
         return true;
     }
  
     // return false if email does not exist in the database
     $errmsg=implode(",",$stmt->errorInfo());
     return false;
}
function getcstudentcount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as cstudentcount FROM `cstudents` where course_id=:course_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );

    // unique ID of record to be edited
    $this->course_id=htmlspecialchars(strip_tags($this->course_id));
    $stmt->bindParam(':course_id', $this->course_id);
 

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->studentcount=$row['cstudentcount'];
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getistudentcount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as istudentcount FROM `istudents` where inst_id=:inst_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );

    // unique ID of record to be edited
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $stmt->bindParam(':inst_id', $this->inst_id);
 

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->studentcount=$row['istudentcount'];
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getpstudentcount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as pstudentcount FROM `pstudents` where partner_id=:partner_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );

    // unique ID of record to be edited
    $this->partner_id=htmlspecialchars(strip_tags($this->partner_id));
    $stmt->bindParam(':partner_id', $this->partner_id);
 

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->studentcount=$row['pstudentcount'];
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getedbstudentcount(){

    // query to check if email exists
    $query = "SELECT count(*) as studentcount FROM " . $this->table_name . " WHERE `edb_id`=:edb_id";

    // prepare the query
    $stmt = $this->conn->prepare( $query );

    // unique ID of record to be edited
    $this->edb_id=htmlspecialchars(strip_tags($this->edb_id));
    $stmt->bindParam(':edb_id', $this->edb_id);

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->studentcount=$row['studentcount'];
        //echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function delete(){
 
    // query to check if email exists
    $query = "DELETE FROM " . $this->table_name . " WHERE `edbs_id`=:edbs_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->edbs_id=htmlspecialchars(strip_tags($this->edbs_id));
    $stmt->bindParam(':edbs_id', $this->edbs_id);

  
    if($stmt->execute()){
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>