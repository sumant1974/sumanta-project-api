<?php
// 'Partner' object
class Partner{
 
    // database connection and table name
    private $conn;
    private $table_name = "partners";
 
    // object properties
    
    public $partner_id;
    public $partner_name;
    public $partner_website;
    public $partner_programme;
    public $partner_programme_website;
    public $allPartners;
    public $partnersCount;
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
                partner_id = :partner_id,
                partner_name = :partner_name,
                partner_website = :partner_website,
                partner_programme = :partner_programme,
                partner_programme_website = :partner_programme_website"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->partner_id=htmlspecialchars(strip_tags($this->partner_id));
    $this->partner_name=htmlspecialchars(strip_tags($this->partner_name));
    $this->partner_website=htmlspecialchars(strip_tags($this->partner_website));
    $this->partner_programme=htmlspecialchars(strip_tags($this->partner_programme));
    $this->partner_programme_website=htmlspecialchars(strip_tags($this->partner_programme_website));
    
     
    // bind the values
	$stmt->bindParam(':partner_id',$this->partner_id);
	$stmt->bindParam(':partner_name',$this->partner_name);
    $stmt->bindParam(':partner_website', $this->partner_website);
    $stmt->bindParam(':partner_programme', $this->partner_programme);
    $stmt->bindParam(':partner_programme_website', $this->partner_programme_website);
   

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
                partner_name = :partner_name,
                partner_website = :partner_website,
                partner_programme = :partner_programme,
                partner_programme_website = :partner_programme_website                
            WHERE
                partner_id=:partner_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->partner_name=htmlspecialchars(strip_tags($this->partner_name));
    $this->partner_website=htmlspecialchars(strip_tags($this->partner_website));
    $this->partner_programme=htmlspecialchars(strip_tags($this->partner_programme));
    $this->partner_programme_website=htmlspecialchars(strip_tags($this->partner_programme_website));
    
 
    // bind the values from the form
    $stmt->bindParam(':partner_name',$this->partner_name);
    $stmt->bindParam(':partner_website', $this->partner_website);
    $stmt->bindParam(':partner_programme', $this->partner_programme);
    $stmt->bindParam(':partner_programme_website', $this->partner_programme_website);
    
    
    // unique ID of record to be edited
    $this->partner_id=htmlspecialchars(strip_tags($this->partner_id));
    $stmt->bindParam(':partner_id', $this->partner_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getPartners(){
 
    // query to check if email exists
    $query = "SELECT `partner_id`,`partner_name`,`partner_website`,`partner_programme`,`partner_programme_website` FROM " . $this->table_name . " order by `partner_name`";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allPartners=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    $errmsg.=", Rows Fetched:" . $num;
    return false;
}
function getPartner(){
 
    // query to check if email exists
    $query = "SELECT `partner_id`,`partner_name`,`partner_website`,`partner_programme`,`partner_programme_website` FROM " . $this->table_name . " WHERE `partner_id`=:partner_id";
 
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
        $this->partner_name=$row['partner_name'];
        $this->partner_website=$row['partner_website'];
        $this->partner_programme=$row['partner_programme'];
        $this->partner_programme_website=$row['partner_programme_website'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function delete(){
 
    // query to check if email exists
    $query = "DELETE FROM " . $this->table_name . " WHERE `partner_id`=:partner_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->partner_id=htmlspecialchars(strip_tags($this->partner_id));
    $stmt->bindParam(':partner_id', $this->partner_id);

  
    if($stmt->execute()){
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getPartnersCount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as partnerscount FROM " . $this->table_name;
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->partnersCount=$row['partnerscount'];
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>