<?php
// 'institute' object
class Spoc{
 
    // database connection and table name
    private $conn;
    private $table_name = "spocs";
 
    // object properties
    
    public $spoc_id;
    public $spoc_firstname;
    public $spoc_lastname;
    public $spoc_mobile;
    public $spoc_email;
    public $spoc_alternate_mobile;
    public $spoc_alternate_email;
    public $inst_id;
     public $allspocs;
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
                spoc_firstname = :spoc_firstname,
                spoc_lastname = :spoc_lastname,
                spoc_mobile = :spoc_mobile,
                spoc_email = :spoc_email,
                spoc_alternate_email = :spoc_alternate_email,
                inst_id = :inst_id,
                spoc_alternate_mobile = :spoc_alternate_mobile"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->spoc_id=htmlspecialchars(strip_tags($this->spoc_id));
    $this->spoc_firstname=htmlspecialchars(strip_tags($this->spoc_firstname));
    $this->spoc_lastname=htmlspecialchars(strip_tags($this->spoc_lastname));
    $this->spoc_mobile=htmlspecialchars(strip_tags($this->spoc_mobile));
    $this->spoc_email=htmlspecialchars(strip_tags($this->spoc_email));
    $this->spoc_alternate_email=htmlspecialchars(strip_tags($this->spoc_alternate_email));
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->spoc_alternate_mobile=htmlspecialchars(strip_tags($this->spoc_alternate_mobile));
     
    // bind the values
	$stmt->bindParam(':spoc_id',$this->spoc_id);
	$stmt->bindParam(':spoc_firstname',$this->spoc_firstname);
    $stmt->bindParam(':spoc_lastname', $this->spoc_lastname);
    $stmt->bindParam(':spoc_mobile', $this->spoc_mobile);
    $stmt->bindParam(':spoc_email', $this->spoc_email);
    $stmt->bindParam(':spoc_alternate_email', $this->spoc_alternate_email);
    $stmt->bindParam(':inst_id', $this->inst_id);
    $stmt->bindParam(':spoc_alternate_mobile', $this->spoc_alternate_mobile);

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
                spoc_firstname = :spoc_firstname,
                spoc_lastname = :spoc_lastname,
                spoc_mobile = :spoc_mobile,
                spoc_email = :spoc_email,
                spoc_alternate_email = :spoc_alternate_email,
                inst_id = :inst_id,
                spoc_alternate_mobile = :spoc_alternate_mobile
            WHERE
                spoc_id=:spoc_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->spoc_firstname=htmlspecialchars(strip_tags($this->spoc_firstname));
    $this->spoc_lastname=htmlspecialchars(strip_tags($this->spoc_lastname));
    $this->spoc_mobile=htmlspecialchars(strip_tags($this->spoc_mobile));
    $this->spoc_email=htmlspecialchars(strip_tags($this->spoc_email));
    $this->spoc_alternate_email=htmlspecialchars(strip_tags($this->spoc_alternate_email));
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->spoc_alternate_mobile=htmlspecialchars(strip_tags($this->spoc_alternate_mobile));
 
    // bind the values from the form
    $stmt->bindParam(':spoc_firstname',$this->spoc_firstname);
    $stmt->bindParam(':spoc_lastname', $this->spoc_lastname);
    $stmt->bindParam(':spoc_mobile', $this->spoc_mobile);
    $stmt->bindParam(':spoc_email', $this->spoc_email);
    $stmt->bindParam(':spoc_alternate_email', $this->spoc_alternate_email);
    $stmt->bindParam(':inst_id', $this->inst_id);
    $stmt->bindParam(':spoc_alternate_mobile', $this->spoc_alternate_mobile);
 
    
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
function getSpocs(){
 
    // query to check if email exists
    $query = "SELECT `spoc_id`,`spoc_firstname`,`spoc_lastname`,`spoc_mobile`,`spoc_email`,`spoc_alternate_mobile`,`spoc_alternate_email`,`inst_id` FROM " . $this->table_name;
 
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
function getSpoc(){
 
    // query to check if email exists
    $query = "SELECT `spoc_id`,`spoc_firstname`,`spoc_lastname`,`spoc_mobile`,`spoc_email`,`spoc_alternate_mobile`,`spoc_alternate_email`,`inst_id` FROM " . $this->table_name . " WHERE `spoc_id`=:spoc_id";
 
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
        $this->spoc_firstname=$row['spoc_firstname'];
        $this->spoc_lastname=$row['spoc_lastname'];
        $this->spoc_mobile=$row['spoc_mobile'];
        $this->spoc_email=$row['spoc_email'];
        $this->spoc_alternate_email=$row['spoc_alternate_email'];
        $this->inst_id=$row['inst_id'];
        $this->spoc_alternate_mobile=$row['spoc_alternate_mobile'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getInstituteSpoc(){
 
    // query to check if email exists
    $query = "SELECT `spoc_id`,`spoc_firstname`,`spoc_lastname`,`spoc_mobile`,`spoc_email`,`spoc_alternate_mobile`,`spoc_alternate_email`,`inst_id` FROM " . $this->table_name . " WHERE `inst_id`=:inst_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->spoc_id=htmlspecialchars(strip_tags($this->inst_id));
    $stmt->bindParam(':spoc_id', $this->inst_id);

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $this->allspocs=$stmt->fetchAll(PDO::FETCH_ASSOC);
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