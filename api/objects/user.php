<?php
// 'user' object
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $user_id;
    public $user_pass;
    public $user_recovery_mobile;
    public $firstname;
    public $lastname;
    public $role_id;
    public $inst_id;
    public $alternate_email;
     public $allusers;
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
                user_id = :user_id,
                user_pass = :user_pass,
                user_recovery_mobile = :user_recovery_mobile,
                firstname = :firstname,
                lastname = :lastname,
                role_id = :role_id,
                inst_id = :inst_id,
                email = :alternate_email";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->user_pass=htmlspecialchars(strip_tags($this->user_pass));
    $this->user_recovery_mobile=htmlspecialchars(strip_tags($this->user_recovery_mobile));
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->role_id=htmlspecialchars(strip_tags($this->role_id));
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->alternate_email=htmlspecialchars(strip_tags($this->alternate_email));
     
    // bind the values
	$stmt->bindParam(':user_id',$this->user_id);
	$stmt->bindParam(':user_recovery_mobile',$this->user_recovery_mobile);
    $stmt->bindParam(':firstname', $this->firstname);
    $stmt->bindParam(':lastname', $this->lastname);
    $stmt->bindParam(':role_id', $this->role_id);
	$stmt->bindParam(':inst_id', $this->inst_id);
	$stmt->bindParam(':alternate_email', $this->alternate_email);
    // hash the password before saving to database
    $password_hash = password_hash($this->user_pass,PASSWORD_DEFAULT);
    $stmt->bindParam(':user_pass', $password_hash);
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
function emailExists(){
 
    // query to check if email exists
    $query = "SELECT `user_id`,`user_pass`,`user_recovery_mobile`,`inst_id`,`firstname`,`lastname`,`email`,`role_id`  FROM " . $this->table_name . " WHERE user_id = '" . htmlspecialchars(strip_tags($this->user_id)) ."'";
 
    // prepare the query
    $this->errmsg=$query;
    $stmt = $this->conn->prepare( $query );
 //echo $query;
    // sanitize
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
// echo $this->user_id;
    // bind given email value
   // $stmt->bindParam(1, $this->user_id);
 
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
        $this->user_id = $row['user_id'];
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->user_recovery_mobile = $row['user_recovery_mobile'];
		$this->user_pass = $row['user_pass'];
		$this->alternate_email = $row['email'];
		$this->role_id= $row['role_id'];
		$this->inst_id = $row['inst_id'];
		
 
        // return true because email exists in the database
        return true;
    }
 
    // return false if email does not exist in the database
    return false;
}
 
// update() method will be here
/*public function update(){
 
    // if password needs to be updated
    $password_set=!empty($this->password) ? ", password = :password" : "";
 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table_name . "
            SET
                user_mobile = :user_mobile,
                first_name = :first_name,
                last_name = :last_name,
                user_desc = :user_desc,
                user_role = :user_role,
                user_org_name = :user_org_name,
                user_netacad_id = :user_mrtc_id
                {$password_set}
            WHERE userid = :user_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->user_mobile=htmlspecialchars(strip_tags($this->user_mobile));
    $this->first_name=htmlspecialchars(strip_tags($this->first_name));
    $this->last_name=htmlspecialchars(strip_tags($this->last_name));
    $this->user_desc=htmlspecialchars(strip_tags($this->user_desc));
    $this->user_role=htmlspecialchars(strip_tags($this->user_role));
    $this->user_org_name=htmlspecialchars(strip_tags($this->user_org_name));
    $this->user_mrtc_id=htmlspecialchars(strip_tags($this->user_mrtc_id));
 
    // bind the values from the form
    $stmt->bindParam(':user_mobile',$this->user_mobile);
    $stmt->bindParam(':first_name', $this->first_name);
    $stmt->bindParam(':last_name', $this->last_name);
    $stmt->bindParam(':user_desc', $this->user_desc);
    $stmt->bindParam(':user_role', $this->user_role);
	$stmt->bindParam(':user_org_name', $this->user_org_name);
	$stmt->bindParam(':user_mrtc_id', $this->user_mrtc_id);
 
    // hash the password before saving to database
    if(!empty($this->password)){
        $this->password=htmlspecialchars(strip_tags($this->password));
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
    }
 
    // unique ID of record to be edited
    $stmt->bindParam(':user_id', $this->user_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
function getUsers(){
 
    // query to check if email exists
    $query = "SELECT userid,password,user_mobile,first_name,last_name,user_desc,user_role,user_org_name,user_netcad_id FROM " . $this->table_name;
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allusers=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    return false;
}*/
}
?>