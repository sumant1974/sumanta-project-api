<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
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
 
// instantiate user object
$user = new User($db);
//$upd_user = new User($db);
// retrieve given jwt here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 

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
    $user->create()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user.","Error"=>$user->errmsg));
}

?>