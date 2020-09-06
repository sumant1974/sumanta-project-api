<?php
// 'PCourse' object
class PCourse{
 
    // database connection and table name
    private $conn;
    private $table_name = "partner_courses";
 
    // object properties
    
    public $course_id;
    public $course_name;
    public $course_outline;
    public $partner_id;
    public $allcourses;
    public $coursesCount;
    public $pcoursesCount;
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
                course_id = :course_id,
                course_name = :course_name,
                course_outline = :course_outline,
                partner_id = :partner_id"
                ;
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->course_id=htmlspecialchars(strip_tags($this->course_id));
    $this->course_name=htmlspecialchars(strip_tags($this->course_name));
    $this->course_outline=htmlspecialchars(strip_tags($this->course_outline));
    $this->partner_id=htmlspecialchars(strip_tags($this->partner_id));
    
     
    // bind the values
	$stmt->bindParam(':course_id',$this->course_id);
	$stmt->bindParam(':course_name',$this->course_name);
    $stmt->bindParam(':course_outline', $this->course_outline);
    $stmt->bindParam(':partner_id', $this->partner_id);
   

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
                course_name = :course_name,
                course_outline = :course_outline,
                partner_id = :partner_id,             
            WHERE
                course_id=:course_id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->course_name=htmlspecialchars(strip_tags($this->course_name));
    $this->course_outline=htmlspecialchars(strip_tags($this->course_outline));
    $this->partner_id=htmlspecialchars(strip_tags($this->partner_id));
    
 
    // bind the values from the form
    $stmt->bindParam(':course_name',$this->course_name);
    $stmt->bindParam(':course_outline', $this->course_outline);
    $stmt->bindParam(':partner_id', $this->partner_id);
    
    
    // unique ID of record to be edited
    $this->course_id=htmlspecialchars(strip_tags($this->course_id));
    $stmt->bindParam(':course_id', $this->course_id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getCourses(){
 
    // query to check if email exists
    $query = "SELECT `course_id`,`course_name`,`course_outline`,`partner_id` FROM " . $this->table_name;
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
		$this->allcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getPCourses(){
 
    // query to check if email exists
    $query = "SELECT `course_id`,`course_name`,`course_outline`,`partner_id` FROM " . $this->table_name . " WHERE `partner_id`=:partner_id";
 
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
		$this->allcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//echo json_encode($allusers);
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getPCourse(){
 
    // query to check if email exists
    $query = "SELECT `course_id`,`course_name`,`course_outline`,`partner_id` FROM " . $this->table_name . " WHERE `course_id`=:course_id";
 
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
        $this->course_name=$row['course_name'];
        $this->course_outline=$row['course_outline'];
        $this->partner_id=$row['partner_id'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getCoursesCount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as coursescount FROM " . $this->table_name;
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    /*/ unique ID of record to be edited
    $this->course_id=htmlspecialchars(strip_tags($this->course_id));
    $stmt->bindParam(':course_id', $this->course_id);*/

    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->coursesCount=$row['coursescount'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function getPCoursesCount(){
 
    // query to check if email exists
    $query = "SELECT count(*) as pcoursescount FROM " . $this->table_name . " WHERE `partner_id`=:partner_id";
 
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
        $this->pcoursesCount=$row['pcoursescount'];
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
function delete(){
 
    // query to check if email exists
    $query = "DELETE FROM " . $this->table_name . " WHERE `course_id`=:course_id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
    // unique ID of record to be edited
    $this->course_id=htmlspecialchars(strip_tags($this->course_id));
    $stmt->bindParam(':course_id', $this->course_id);

  
    if($stmt->execute()){
        return true;
    }
 
    // return false if email does not exist in the database
    $errmsg=implode(",",$stmt->errorInfo());
    return false;
}
}
?>