<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$auth_role=array("1");
// files for decoding jwt will be here
// required to encode json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// database connection will be here
// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/user.php';
include_once '../objects/institute.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$user = new User($db);
$inst=new Institute($db);
//$upd_user = new User($db);
// retrieve given jwt here
// get posted data
$data = json_decode(file_get_contents("php://input"));

// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";

// decode jwt here
// if jwt is not empty
if($jwt){
 
    // if decode succeed, show user details
    try {
 
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
 
        // set user property values here
		$user->role_id = $decoded->data->role_id;
		
    }
 
    // catch failed decoding will be here

 
// error message if jwt is empty will be here
// if decode fails, it means jwt is invalid
catch (Exception $e){
 
    // set response code
    http_response_code(401);
 
    // show error message
    echo json_encode(array(
        "message" => "Access denied.",
        "error" => $e->getMessage(),
        "status"=>"0"
    ));
}
//Write action code here
if(in_array($user->role_id,$auth_role,true))
{
    // set product property values
    $inst->inst_id=$data->inst_id;
    $inst->inst_name=$data->inst_name;
    $inst->inst_shortname=$data->inst_shortname;
    $inst->inst_state=$data->inst_state;
    $inst->inst_website=$data->inst_website;
    $inst->inst_address=$data->inst_address;
    $inst->inst_phone=$data->inst_phone;
    $inst->inst_email=$data->inst_email;
    $inst->principal_name=$data->principal_name;;
 // $status=$inst->update();
// use the create() method here
// create the user
if(
    !empty($inst->inst_id) &&
    !empty($inst->inst_name) &&
    !empty($inst->inst_shortname) &&
    !empty($inst->inst_state) &&
    !empty($inst->inst_address) &&
    !empty($inst->inst_phone) &&
    !empty($inst->inst_email) &&
    !empty($inst->principal_name) &&
    !empty($inst->inst_website) &&
    $inst->update()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "Institute Details Updated Successfully","status"=>"1"));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to Update Institute. ".$inst->errmsg.$status,"status"=>"0"));
}
}
else
{
	http_response_code(401);
 
    // show error message
    echo json_encode(array(
        "message" => "Access denied.","status"=>"0"
        
    ));
}

}
else
{
	http_response_code(401);
 
    // show error message
    echo json_encode(array(
        "message" => "Access denied.","status"=>"0" 
        
    ));
}
?>