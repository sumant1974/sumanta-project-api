<?php
// 'edbatch' object
class EdBatch{
 
    // database connection and table name
    private $conn;
    private $table_name = "educator_batches";
 
    // object properties
    public $edb_id;
    public $educator_id;
    public $course_id;
    public $edb_name;
    public $edb_start_date;
    public $edb_end_date;
    public $alledbatchess;
    public $edbatchescount;
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
                course_id = :course_id,
                edb_name = :edb_name,
                edb_start_date = :edb_start_date,
                edb_end_date = :edb_end_date"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->educator_id=htmlspecialchars(strip_tags($this->educator_id));
    $this->course_id=htmlspecialchars(strip_tags($this->course_id));
    $this->edb_name=htmlspecialchars(strip_tags($this->edb_name));
    $this->edb_start_date=htmlspecialchars(strip_tags($this->edb_start_date));
    $this->edb_end_date=htmlspecialchars(strip_tags($this->edb_end_date));
    
    // bind the values
	$stmt->bindParam(':educator_id',$this->educator_id);
    $stmt->bindParam(':course_id',$this->course_id);
    $stmt->bindParam(':edb_name',$this->edb_name);
    $stmt->bindParam(':edb_start_date',$this->edb_start_date);
    $stmt->bindParam(':edb_end_date',$this->edb_end_date);
    

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
                course_id = :course_id,
                educator_id=:educator_id,
                edb_name = :edb_name,
                edb_start_date = :edb_start_date,
                edb_end_date = :edb_end_date
                WHERE
                edb_id= :edb_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->course_id=htmlspecialchars(strip_tags($this->course_id));
    $this->educator_id=htmlspecialchars(strip_tags($this->educator_id));
    $this->edb_name=htmlspecialchars(strip_tags($this->edb_name));
    $this->edb_start_date=htmlspecialchars(strip_tags($this->edb_start_date));
    $this->edb_end_date=htmlspecialchars(strip_tags($this->edb_end_date));
    
 
    // bind the values from the form
    $stmt->bindParam(':course_id',$this->course_id);
    $stmt->bindParam(':educator_id', $this->educator_id);
    $stmt->bindParam(':edb_name',$this->edb_name);
    $stmt->bindParam(':edb_start_date',$this->edb_start_date);
    $stmt->bindParam(':edb_end_date',$this->edb_end_date);
    
    
    // unique ID of record to be edited
    $this->edb_id=htmlspecialchars(strip_tags($this->edb_id));
    $stmt->bindParam(':edb_id', $this->edb_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
//Institute Partners

function getEdBatches(){
 
    // query to check if email exists
    $query = "SELECT `edb_id`,`educator_id`,`edb_name`,`edb_start_date`,`edb_end_date`,`course_id` FROM ". $table_name ." WHERE `educator_id`=:educator_id";
 
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
		$this->alledbatchess=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getEdBatchesCount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as edbatchescount FROM ". $table_name . " WHERE `educator_id`=:educator_id";
 
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
        $this->edbatchescount=$row['edbatchescount'];
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
/*Partner Institutes
function getCEducators(){
 
    // query to check if email exists
    $query = "SELECT * FROM ceducators WHERE `course_id`=:course_id";
 
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
		$this->allceducators=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getCEducatorsCount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as pinstitutescount FROM ". $table_name . " WHERE `course_id`=:course_id";
 
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
    $query = "SELECT `edb_id$edb_id$edb_id`,`educator_id`,`course_id`,`partner_name`,`partner_programme`,`partner_website`,`partner_programme_website` FROM IPartners WHERE `edb_id$edb_id$edb_id`=:edb_id$edb_id$edb_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->educator_id=htmlspecialchars(strip_tags($this->edb_id$edb_id$edb_id));
    $stmt->bindParam(':educator_id', $this->edb_id$edb_id$edb_id);

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->course_id=$row['course_id'];
        $this->educator_id=$row['educator_id'];
        $this->partner_name=$row['partner_name'];
        $this->partner_programme=$row['partner_programme'];
        $this->partner_website=$row['partner_website'];
        $this->partner_programme_website=$row['partner_programme_website'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}*/
function delete(){
 
    // query to check if email exists
    $query = "DELETE FROM " . $this->table_name . " WHERE `edb_id`=:edb_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->edb_id=htmlspecialchars(strip_tags($this->edb_id));
    $stmt->bindParam(':edb_id', $this->edb_id);

  
    if($stmt->execute()){
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>