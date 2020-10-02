<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
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
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// spocantiate user object
$user = new User($db);
$auser = new User($db);
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
		$auser->role_id = $decoded->data->role_id;
		
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
if(in_array($auser->role_id,$auth_role,true))
{
	// set product property values
    $user->user_id = $data->user_id;
$user->user_pass = $data->user_pass;
$user->user_recovery_mobile = $data->user_recovery_mobile;
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->alternate_email = $data->alternate_email;
$user->role_id = $data->role_id;
$user->inst_id = $data->inst_id;
 
// use the create() method here
// create the user
if(
    !empty($user->user_id) &&
    !empty($user->firstname) &&
    !empty($user->lastname) &&
    !empty($user->user_recovery_mobile) &&
    !empty($user->role_id) &&
    !empty($user->inst_id) &&
    $user->update()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "User Updated Successfully","status"=>"1"));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to Update User. ".$user->errmsg,"status"=>"0"));
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