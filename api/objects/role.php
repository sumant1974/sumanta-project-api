<?php
// 'role' object
class Role{
 
    // database connection and table name
    private $conn;
    private $table_name = "roles";
 
    // object properties
    
    public $role_id;
    public $role_name;
    public $menu;
     public $allroles;
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
                role_id = :role_id,
                role_name = :role_name,
                menu = :menu";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->role_id=htmlspecialchars(strip_tags($this->role_id));
    $this->role_name=htmlspecialchars(strip_tags($this->role_name));
    $this->menu=htmlspecialchars(strip_tags($this->menu));
    
     
    // bind the values
	$stmt->bindParam(':role_id',$this->role_id);
	$stmt->bindParam(':role_name',$this->role_name);
    $stmt->bindParam(':menu', $this->menu);
    
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
 
// emailExists() method will be here
public function getMenu(){
 
    // query to check if email exists
    $query = "SELECT `role_name`,`menu`  FROM " . $this->table_name . " WHERE role_id = " . htmlspecialchars(strip_tags($this->role_id));
 
    // prepare the query
    //$this->errmsg=$query;
    
    $stmt = $this->conn->prepare( $query );
 //echo $query;
    // sanitize
  //  $this->user_id=htmlspecialchars(strip_tags($this->user_id));
// echo $this->user_id;
    // bind given email value
    $stmt->bindParam(1, $this->role_id);
 
    // execute the query
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 //echo $num;
    // if email exists, assign values to object properties for easy access and use for php sessions
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // assign values to object properties
        $this->role_name= $row['role_name'];
        $this->menu = $row['menu'];
         
        // return true because email exists in the database
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
 
// update() method will be here
public function update(){
 
    // if password needs to be updated
    //$password_set=!empty($this->password) ? ", password = :password" : "";
 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table_name . "
            SET
            role_name = :role_name,
            menu = :menu
            WHERE role_id = :role_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->role_name=htmlspecialchars(strip_tags($this->role_name));
    $this->menu=htmlspecialchars(strip_tags($this->menu));
 
    // bind the values from the form
    $stmt->bindParam(':role_name',$this->role_name);
    $stmt->bindParam(':menu', $this->menu);
 
    
    // unique ID of record to be edited
    $this->role_id=htmlspecialchars(strip_tags($this->role_id));
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getRoles(){
 
    // query to check if email exists
    $query = "SELECT `role_id`,`role_name`,`menu` FROM " . $this->table_name;
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allroles=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>