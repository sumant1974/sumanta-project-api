<?php
// 'ISpoc' object
class ISpoc{
 
    // database connection and table name
    private $conn;
    private $table_name = "spocs";
 
    // object properties
    
    public $spoc_id;
    public $inst_id;
    public $spoc_firstname;
    public $spoc_lastname;
    public $spoc_mobile;
    public $spoc_email;
    public $spoc_alternate_mobile;
    public $spoc_alternate_email;
     public $allspocs;
     public $spoccount;
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
                spoc_id = :spoc_id,
                inst_id = :inst_id,
                spoc_firstname = :spoc_firstname,
                spoc_lastname = :spoc_lastname,
                spoc_mobile = :spoc_mobile,
                spoc_alternate_mobile = :spoc_alternate_mobile,
                spoc_alternate_email = :spoc_alternate_email,
                spoc_email = :spoc_email"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->spoc_id=htmlspecialchars(strip_tags($this->spoc_id));
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->spoc_firstname=htmlspecialchars(strip_tags($this->spoc_firstname));
    $this->spoc_lastname=htmlspecialchars(strip_tags($this->spoc_lastname));
    $this->spoc_mobile=htmlspecialchars(strip_tags($this->spoc_mobile));
    $this->spoc_alternate_mobile=htmlspecialchars(strip_tags($this->spoc_alternate_mobile));
    $this->spoc_alternate_email=htmlspecialchars(strip_tags($this->spoc_alternate_email));
    $this->spoc_email=htmlspecialchars(strip_tags($this->spoc_email));
     
    // bind the values
	$stmt->bindParam(':spoc_id',$this->spoc_id);
	$stmt->bindParam(':inst_id',$this->inst_id);
    $stmt->bindParam(':spoc_firstname', $this->spoc_firstname);
    $stmt->bindParam(':spoc_lastname', $this->spoc_lastname);
    $stmt->bindParam(':spoc_mobile', $this->spoc_mobile);
    $stmt->bindParam(':spoc_alternate_mobile', $this->spoc_alternate_mobile);
    $stmt->bindParam(':spoc_alternate_email', $this->spoc_alternate_email);
    $stmt->bindParam(':spoc_email', $this->spoc_email);

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
                spoc_firstname = :spoc_firstname,
                spoc_lastname = :spoc_lastname,
                spoc_mobile = :spoc_mobile,
                spoc_alternate_mobile = :spoc_alternate_mobile,
                spoc_alternate_email = :spoc_alternate_email,
                spoc_email = :spoc_email
            WHERE
                spoc_id=:spoc_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->spoc_firstname=htmlspecialchars(strip_tags($this->spoc_firstname));
    $this->spoc_lastname=htmlspecialchars(strip_tags($this->spoc_lastname));
    $this->spoc_mobile=htmlspecialchars(strip_tags($this->spoc_mobile));
    $this->spoc_alternate_mobile=htmlspecialchars(strip_tags($this->spoc_alternate_mobile));
    $this->spoc_alternate_email=htmlspecialchars(strip_tags($this->spoc_alternate_email));
    $this->spoc_email=htmlspecialchars(strip_tags($this->spoc_email));
 
    // bind the values from the form
    $stmt->bindParam(':inst_id',$this->inst_id);
    $stmt->bindParam(':spoc_firstname', $this->spoc_firstname);
    $stmt->bindParam(':spoc_lastname', $this->spoc_lastname);
    $stmt->bindParam(':spoc_mobile', $this->spoc_mobile);
    $stmt->bindParam(':spoc_alternate_mobile', $this->spoc_alternate_mobile);
    $stmt->bindParam(':spoc_alternate_email', $this->spoc_alternate_email);
    $stmt->bindParam(':spoc_email', $this->spoc_email);
 
    
    // unique ID of record to be edited
    $this->spoc_id=htmlspecialchars(strip_tags($this->spoc_id));
    $stmt->bindParam(':spoc_id', $this->spoc_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getallspocs(){
 
    // query to check if email exists
    $query = "SELECT `spoc_id`,`inst_id`,`spoc_firstname`,`spoc_lastname`,`spoc_mobile`,`spoc_email`,`spoc_alternate_mobile`,`spoc_alternate_email` FROM " . $this->table_name;
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allspocs=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getispocs(){
 
    // query to check if email exists
    $query = "SELECT `spoc_id`,`inst_id`,`inst_name`,`spoc_firstname`,`spoc_lastname`,`spoc_mobile`,`spoc_email`,`spoc_alternate_mobile`,`spoc_alternate_email` FROM `ispocs`";
 
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
		$this->allspocs=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getispoc(){
 
    // query to check if email exists
    $query = "SELECT `spoc_id`,`inst_id`,`inst_name`,`spoc_firstname`,`spoc_lastname`,`spoc_mobile`,`spoc_email`,`spoc_alternate_mobile`,`spoc_alternate_email` FROM `ispocs` WHERE `inst_id`=:inst_id";
 
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
		$this->allspocs=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getspoc(){
 
    // query to check if email exists
    $query = "SELECT `spoc_id`,`inst_id`,`spoc_firstname`,`spoc_lastname`,`spoc_mobile`,`spoc_email`,`spoc_alternate_mobile`,`spoc_alternate_email` FROM " . $this->table_name . " WHERE `spoc_id`=:spoc_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->spoc_id=htmlspecialchars(strip_tags($this->spoc_id));
    $stmt->bindParam(':spoc_id', $this->spoc_id);

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->inst_id=$row['inst_id'];
        $this->spoc_firstname=$row['spoc_firstname'];
        $this->spoc_lastname=$row['spoc_lastname'];
        $this->spoc_mobile=$row['spoc_mobile'];
        $this->spoc_alternate_mobile=$row['spoc_alternate_mobile'];
        $this->spoc_alternate_email=$row['spoc_alternate_email'];
        $this->spoc_email=$row['spoc_email'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getSpocsCount(){

     // query to check if email exists
     $query = "SELECT count(*) as spoccount FROM " . $this->table_name;
 
     // prepare the query
     $stmt = $this->conn->prepare( $query );
 
     $stmt->execute();
  
     // get number of rows
     $num = $stmt->rowCount();
  
     if($num>0){
  
         // get record details / values
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->spoccount=$row['spoccount'];
         //echo json_encode($allusers);
         return true;
     }
  
     // return false if email does not exist in the database
     $errmsg=implode(",",$stmt->errorInfo());
     return false;
}
function getISpocsCount(){

    // query to check if email exists
    $query = "SELECT count(*) as spoccount FROM " . $this->table_name . " WHERE `inst_id`=:inst_id";

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
        $this->spoccount=$row['spoccount'];
        //echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function delete(){
 
    // query to check if email exists
    $query = "DELETE FROM " . $this->table_name . " WHERE `spoc_id`=:spoc_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->spoc_id=htmlspecialchars(strip_tags($this->spoc_id));
    $stmt->bindParam(':spoc_id', $this->spoc_id);

  
    if($stmt->execute()){
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>