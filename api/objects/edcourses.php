<?php
// 'edcourse' object
class EdCourse{
 
    // database connection and table name
    private $conn;
    private $table_name = "educator_courses";
 
    // object properties
    public $edc_id;
    public $educator_id;
    public $course_id;
    public $alledcourses;
    public $edcoursescount;
    public $allceducators;
    public $ceducatorscount;
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
                course_id = :course_id"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->educator_id=htmlspecialchars(strip_tags($this->educator_id));
    $this->course_id=htmlspecialchars(strip_tags($this->course_id));
    
    // bind the values
	$stmt->bindParam(':educator_id',$this->educator_id);
	$stmt->bindParam(':course_id',$this->course_id);
    

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
                WHERE
                edc_id= :edc_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->course_id=htmlspecialchars(strip_tags($this->course_id));
    $this->educator_id=htmlspecialchars(strip_tags($this->educator_id));
    
 
    // bind the values from the form
    $stmt->bindParam(':course_id',$this->course_id);
    $stmt->bindParam(':educator_id', $this->educator_id);
    
    
    // unique ID of record to be edited
    $this->edc_id=htmlspecialchars(strip_tags($this->edc_id));
    $stmt->bindParam(':edc_id', $this->edc_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
//Institute Partners

function getEdCourses(){
 
    // query to check if email exists
    $query = "SELECT `edc_id`,`educator_id`,`course_id`,`course_name`,`course_outline`,`partner_id` FROM edcourses WHERE `educator_id`=:educator_id";
 
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
		$this->alledcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getEdCoursesCount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as edcoursescount FROM ". $table_name . " WHERE `educator_id`=:educator_id";
 
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
        $this->edcoursescount=$row['edcoursescount'];
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
//Partner Institutes
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

/*function getIPartner(){
 
    // query to check if email exists
    $query = "SELECT `edc_id$edc_id`,`educator_id`,`course_id`,`partner_name`,`partner_programme`,`partner_website`,`partner_programme_website` FROM IPartners WHERE `edc_id$edc_id`=:edc_id$edc_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->educator_id=htmlspecialchars(strip_tags($this->edc_id$edc_id));
    $stmt->bindParam(':educator_id', $this->edc_id$edc_id);

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
    $query = "DELETE FROM " . $this->table_name . " WHERE `edc_id`=:edc_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->edc_id=htmlspecialchars(strip_tags($this->edc_id));
    $stmt->bindParam(':edc_id', $this->edc_id);

  
    if($stmt->execute()){
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>