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
include_once '../objects/ispocs.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// spocantiate user object
$user = new User($db);
$ispoc=new ISpoc($db);
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
    $ispoc->spoc_firstname=$data->spoc_firstname;
    $ispoc->spoc_lastname=$data->spoc_lastname;
    $ispoc->spoc_mobile=$data->spoc_mobile;
    $ispoc->spoc_alternate_mobile=$data->spoc_alternate_mobile;
    $ispoc->spoc_alternate_email=$data->spoc_alternate_email;
    $ispoc->spoc_email=$data->spoc_email;
    $ispoc->inst_id=$data->inst_id;
 
// use the create() method here
// create the user
if(
    !empty($ispoc->spoc_firstname) &&
    !empty($ispoc->spoc_lastname) &&
    !empty($ispoc->spoc_mobile) &&
    !empty($ispoc->spoc_email) &&
    !empty($ispoc->inst_id) &&
    $ispoc->create()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "Spoc Added Successfully","status"=>"1"));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to add Spoc. ".$ispoc->errmsg,"status"=>"0"));
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