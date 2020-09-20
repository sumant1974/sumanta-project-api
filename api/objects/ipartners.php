<?php
// 'ipartner' object
class IPartner{
 
    // database connection and table name
    private $conn;
    private $table_name = "institute_partners";
 
    // object properties
    public $ipr_id;
    public $inst_id;
    public $partner_id;
    public $partner_name;
    public $partner_website;
    public $partner_programme_website;
    public $allipartners;
    public $ipartnerscount;
    public $allpinstitutes;
    public $pinstitutescount;
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
                partner_id = :partner_id"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->partner_id=htmlspecialchars(strip_tags($this->partner_id));
    
    // bind the values
	$stmt->bindParam(':inst_id',$this->inst_id);
	$stmt->bindParam(':partner_id',$this->partner_id);
    

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
                partner_id = :partner_id,
                inst_id=:inst_id
                WHERE
                ipr_id= :ipr_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->partner_id=htmlspecialchars(strip_tags($this->partner_id));
    $this->inst_id=htmlspecialchars(strip_tags($this->inst_id));
    $this->inst_state=htmlspecialchars(strip_tags($this->inst_state));
    $this->inst_address=htmlspecialchars(strip_tags($this->inst_address));
    $this->inst_phone=htmlspecialchars(strip_tags($this->inst_phone));
    $this->inst_email=htmlspecialchars(strip_tags($this->inst_email));
    $this->principal_name=htmlspecialchars(strip_tags($this->principal_name));
 
    // bind the values from the form
    $stmt->bindParam(':partner_id',$this->partner_id);
    $stmt->bindParam(':inst_id', $this->inst_id);
    
    
    // unique ID of record to be edited
    $this->ipr_id=htmlspecialchars(strip_tags($this->ipr_id));
    $stmt->bindParam(':ipr_id', $this->ipr_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
//Institute Partners

function getIPartners(){
 
    // query to check if email exists
    $query = "SELECT `ipr_id`,`inst_id`,`partner_id`,`partner_name`,`partner_programme`,`partner_website`,`partner_programme_website` FROM IPartners WHERE `inst_id`=:inst_id";
 
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
		$this->allipartners=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getIPartnersCount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as ipartnerscount FROM ". $table_name . " WHERE `inst_id`=:inst_id";
 
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
        $this->ipartnerscount=$row['ipartnerscount'];
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
//Partner Institutes
function getPInstitutes(){
 
    // query to check if email exists
    $query = "SELECT `ipr_id`,`partner_id`,`inst_id`,`inst_name`,`inst_shortname`,`inst_state`,`inst_address`,`principal_name`,`inst_phone`,`inst_email`,`inst_website` FROM IPartners WHERE `partner_id`=:partner_id";
 
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
		$this->allpinstitutes=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getPInstitutesCount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as pinstitutescount FROM ". $table_name . " WHERE `partner_id`=:partner_id";
 
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
        $this->pinstitutescount=$row['pinstitutescount'];
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}

function getIPartner(){
 
    // query to check if email exists
    $query = "SELECT `ipr_id`,`inst_id`,`partner_id`,`partner_name`,`partner_programme`,`partner_website`,`partner_programme_website` FROM IPartners WHERE `ipr_id`=:ipr_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->inst_id=htmlspecialchars(strip_tags($this->ipr_id));
    $stmt->bindParam(':inst_id', $this->ipr_id);

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->partner_id=$row['partner_id'];
        $this->inst_id=$row['inst_id'];
        $this->partner_name=$row['partner_name'];
        $this->partner_programme=$row['partner_programme'];
        $this->partner_website=$row['partner_website'];
        $this->partner_programme_website=$row['partner_programme_website'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function delete(){
 
    // query to check if email exists
    $query = "DELETE FROM " . $this->table_name . " WHERE `ipr_id`=:ipr_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->ipr_id=htmlspecialchars(strip_tags($this->ipr_id));
    $stmt->bindParam(':ipr_id', $this->ipr_id);

  
    if($stmt->execute()){
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>