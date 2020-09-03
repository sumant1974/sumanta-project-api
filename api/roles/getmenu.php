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
include_once '../objects/role.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate user object
$role = new Role($db);
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
		$role->role_id = $decoded->data->role_id;
    }
 
    // catch failed decoding will be here

 
// error message if jwt is empty will be here
// if decode fails, it means jwt is invalid
catch (Exception $e){
 
    // set response code
    http_response_code(401);
 
    // show error message
    echo json_encode(array(
        "message" => "Error Occured",
        "error" => $e->getMessage()
    ));
}
if($role->getMenu())
{
	 // set response code
    http_response_code(200);
 
    // display message: user was created
    
	echo $role->menu;
}
else
{
	// set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => $errmsg));
}
//Write action code here
}

?>