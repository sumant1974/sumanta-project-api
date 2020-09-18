<?php
// 'Educator' object
class Educator{
 
    // database connection and table name
    private $conn;
    private $table_name = "educators";
 
    // object properties
    
    public $educator_id;
    public $inst_id;
    public $educator_firstname;
    public $educator_lastname;
    public $educator_mobile;
    public $educator_email;
    public $educator_alternate_email;
    public $educator_alternate_mobile;
    public $educator_status;
     public $alleducators;
     public $educatorcount;
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
                educator_id = :educator_id,
                inst_id = :inst_id,
                educator_firstname = :educator_firstname,
                educator_lastname = :educator_lastname,
                educator_mobile = :educator_mobile,
                educator_alternate_email = :educator_alternate_email,
                educator_alternate_mobile = :educator_alternate_mobile,
                educator_email = :educator_email,
                educator_status = :educator_status"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->educator_id=htmlspecialchars(strip_tags($this->educator_id));
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->educator_firstname=htmlspecialchars(strip_tags($this->educator_firstname));
    $this->educator_lastname=htmlspecialchars(strip_tags($this->educator_lastname));
    $this->educator_mobile=htmlspecialchars(strip_tags($this->educator_mobile));
    $this->educator_alternate_email=htmlspecialchars(strip_tags($this->educator_alternate_email));
    $this->educator_alternate_mobile=htmlspecialchars(strip_tags($this->educator_alternate_mobile));
    $this->educator_email=htmlspecialchars(strip_tags($this->educator_email));
    $this->educator_status=htmlspecialchars(strip_tags($this->educator_status));
    // bind the values
	$stmt->bindParam(':educator_id',$this->educator_id);
	$stmt->bindParam(':inst_id',$this->inst_id);
    $stmt->bindParam(':educator_firstname', $this->educator_firstname);
    $stmt->bindParam(':educator_lastname', $this->educator_lastname);
    $stmt->bindParam(':educator_mobile', $this->educator_mobile);
    $stmt->bindParam(':educator_alternate_email', $this->educator_alternate_email);
    $stmt->bindParam(':educator_alternate_mobile', $this->educator_alternate_mobile);
    $stmt->bindParam(':educator_email', $this->educator_email);
    $stmt->bindParam(':educator_status', $this->educator_status);

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
                inst_id = :inst_id,
                educator_firstname = :educator_firstname,
                educator_lastname = :educator_lastname,
                educator_mobile = :educator_mobile,
                educator_alternate_email = :educator_alternate_email,
                educator_alternate_mobile = :educator_alternate_mobile,
                educator_email = :educator_email,
                educator_status = :educator_status
            WHERE
                educator_id=:educator_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->educator_firstname=htmlspecialchars(strip_tags($this->educator_firstname));
    $this->educator_lastname=htmlspecialchars(strip_tags($this->educator_lastname));
    $this->educator_mobile=htmlspecialchars(strip_tags($this->educator_mobile));
    $this->educator_alternate_email=htmlspecialchars(strip_tags($this->educator_alternate_email));
    $this->educator_alternate_mobile=htmlspecialchars(strip_tags($this->educator_alternate_mobile));
    $this->educator_email=htmlspecialchars(strip_tags($this->educator_email));
    $this->educator_status=htmlspecialchars(strip_tags($this->educator_status));
 
    // bind the values from the form
    $stmt->bindParam(':inst_id',$this->inst_id);
    $stmt->bindParam(':educator_firstname', $this->educator_firstname);
    $stmt->bindParam(':educator_lastname', $this->educator_lastname);
    $stmt->bindParam(':educator_mobile', $this->educator_mobile);
    $stmt->bindParam(':educator_alternate_email', $this->educator_alternate_email);
    $stmt->bindParam(':educator_alternate_mobile', $this->educator_alternate_mobile);
    $stmt->bindParam(':educator_email', $this->educator_email);
    $stmt->bindParam(':educator_status', $this->educator_status);
 
    
    // unique ID of record to be edited
    $this->educator_id=htmlspecialchars(strip_tags($this->educator_id));
    $stmt->bindParam(':educator_id', $this->educator_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getalleducatorss(){
 
    // query to check if email exists
    $query = "SELECT `educator_id`,`inst_id`,`educator_firstname`,`educator_lastname`,`educator_mobile`,`educator_email`,`educator_alternate_email`,`educator_alternate_mobile`,`educator_status` FROM " . $this->table_name;
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->alleducators=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getieducators(){
 
    // query to check if email exists
    $query = "SELECT `educator_id`,`inst_id`,`educator_firstname`,`educator_lastname`,`educator_mobile`,`educator_email`,`educator_alternate_email`,`educator_alternate_mobile`,`educator_status` FROM " . $this->table_name . " WHERE `inst_id`=:inst_id";
 
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
		$this->alleducators=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function geteducator(){
 
    // query to check if email exists
    $query = "SELECT `educator_id`,`inst_id`,`educator_firstname`,`educator_lastname`,`educator_mobile`,`educator_email`,`educator_alternate_email`,`educator_alternate_mobile`,`educator_status` FROM " . $this->table_name . " WHERE `educator_id`=:educator_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->educator_id=htmlspecialchars(strip_tags($this->educator_id));
    $stmt->bindParam(':educator_id', $this->educator_id);

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->inst_id=$row['inst_id'];
        $this->educator_firstname=$row['educator_firstname'];
        $this->educator_lastname=$row['educator_lastname'];
        $this->educator_mobile=$row['educator_mobile'];
        $this->educator_alternate_email=$row['educator_alternate_email'];
        $this->educator_alternate_mobile=$row['educator_alternate_mobile'];
        $this->educator_email=$row['educator_email'];
        $this->educator_status=$row['educator_status'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getEducatorsCount(){

     // query to check if email exists
     $query = "SELECT count(*) as educatorcount FROM " . $this->table_name;
 
     // prepare the query
     $stmt = $this->conn->prepare( $query );
 
     $stmt->execute();
  
     // get number of rows
     $num = $stmt->rowCount();
  
     if($num>0){
  
         // get record details / values
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->educatorcount=$row['educatorcount'];
         //echo json_encode($allusers);
         return true;
     }
  
     // return false if email does not exist in the database
     $errmsg=implode(",",$stmt->errorInfo());
     return false;
}
function getIEducatorsCount(){

    // query to check if email exists
    $query = "SELECT count(*) as educatorcount FROM " . $this->table_name . " WHERE `inst_id`=:inst_id";

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
        $this->educatorcount=$row['educatorcount'];
        //echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function delete(){
 
    // query to check if email exists
    $query = "DELETE FROM " . $this->table_name . " WHERE `educator_id`=:educator_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->educator_id=htmlspecialchars(strip_tags($this->educator_id));
    $stmt->bindParam(':educator_id', $this->educator_id);

  
    if($stmt->execute()){
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>