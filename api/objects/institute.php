<?php
// 'institute' object
class Institute{
 
    // database connection and table name
    private $conn;
    private $table_name = "institutes";
 
    // object properties
    
    public $inst_id;
    public $inst_name;
    public $inst_shortname;
    public $inst_state;
    public $inst_address;
    public $principal_name;
    public $inst_phone;
    public $inst_email;
    public $inst_website;
     public $allinstitutes;
     public $instcount;
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
                inst_id = :inst_id,
                inst_name = :inst_name,
                inst_shortname = :inst_shortname,
                inst_state = :inst_state,
                inst_address = :inst_address,
                inst_phone = :inst_phone,
                inst_email = :inst_email,
                principal_name = :principal_name,
                inst_website = :inst_website"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->inst_name=htmlspecialchars(strip_tags($this->inst_name));
    $this->inst_shortname=htmlspecialchars(strip_tags($this->inst_shortname));
    $this->inst_state=htmlspecialchars(strip_tags($this->inst_state));
    $this->inst_address=htmlspecialchars(strip_tags($this->inst_address));
    $this->inst_phone=htmlspecialchars(strip_tags($this->inst_phone));
    $this->inst_email=htmlspecialchars(strip_tags($this->inst_email));
    $this->principal_name=htmlspecialchars(strip_tags($this->principal_name));
    $this->inst_website=htmlspecialchars(strip_tags($this->inst_website));
     
    // bind the values
	$stmt->bindParam(':inst_id',$this->inst_id);
	$stmt->bindParam(':inst_name',$this->inst_name);
    $stmt->bindParam(':inst_shortname', $this->inst_shortname);
    $stmt->bindParam(':inst_state', $this->inst_state);
    $stmt->bindParam(':inst_address', $this->inst_address);
    $stmt->bindParam(':inst_phone', $this->inst_phone);
    $stmt->bindParam(':inst_email', $this->inst_email);
    $stmt->bindParam(':principal_name', $this->principal_name);
    $stmt->bindParam('inst_website', $this->inst_website);

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
                inst_name = :inst_name,
                inst_shortname = :inst_shortname,
                inst_state = :inst_state,
                inst_address = :inst_address,
                inst_phone = :inst_phone,
                inst_email = :inst_email,
                principal_name = :principal_name,
                inst_website = :inst_website
            WHERE
                inst_id=:inst_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->inst_name=htmlspecialchars(strip_tags($this->inst_name));
    $this->inst_shortname=htmlspecialchars(strip_tags($this->inst_shortname));
    $this->inst_state=htmlspecialchars(strip_tags($this->inst_state));
    $this->inst_address=htmlspecialchars(strip_tags($this->inst_address));
    $this->inst_phone=htmlspecialchars(strip_tags($this->inst_phone));
    $this->inst_email=htmlspecialchars(strip_tags($this->inst_email));
    $this->principal_name=htmlspecialchars(strip_tags($this->principal_name));
    $this->inst_website=htmlspecialchars(strip_tags($this->inst_website));
 
    // bind the values from the form
    $stmt->bindParam(':inst_name',$this->inst_name);
    $stmt->bindParam(':inst_shortname', $this->inst_shortname);
    $stmt->bindParam(':inst_state', $this->inst_state);
    $stmt->bindParam(':inst_address', $this->inst_address);
    $stmt->bindParam(':inst_phone', $this->inst_phone);
    $stmt->bindParam(':inst_email', $this->inst_email);
    $stmt->bindParam(':principal_name', $this->principal_name);
    $stmt->bindParam('inst_website', $this->inst_website);
 
    
    // unique ID of record to be edited
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $stmt->bindParam(':inst_id', $this->inst_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $this->errmsg=implode(",",$stmt->errorInfo());
    return $this->errmsg;
}
function getInstitutes(){
 
    // query to check if email exists
    $query = "SELECT `inst_id`,`inst_name`,`inst_shortname`,`inst_state`,`inst_address`,`principal_name`,`inst_phone`,`inst_email`,`inst_website` FROM " . $this->table_name . " order by `inst_state`, `inst_name`";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allinstitutes=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getInstitutesCount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as instcount FROM " . $this->table_name;
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->instcount=$row['instcount'];
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getInstitute(){
 
    // query to check if email exists
    $query = "SELECT `inst_id`,`inst_name`,`inst_shortname`,`inst_state`,`inst_address`,`principal_name`,`inst_phone`,`inst_email`,`inst_website` FROM " . $this->table_name . " WHERE `inst_id`=:inst_id";
 
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
        $this->inst_name=$row['inst_name'];
        $this->inst_shortname=$row['inst_shortname'];
        $this->inst_state=$row['inst_state'];
        $this->inst_address=$row['inst_address'];
        $this->inst_phone=$row['inst_phone'];
        $this->inst_email=$row['inst_email'];
        $this->principal_name=$row['principal_name'];
        $this->inst_website=$row['inst_website'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function delete(){
 
    // query to check if email exists
    $query = "DELETE FROM " . $this->table_name . " WHERE `inst_id`=:inst_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $stmt->bindParam(':inst_id', $this->inst_id);

  
    if($stmt->execute()){
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>