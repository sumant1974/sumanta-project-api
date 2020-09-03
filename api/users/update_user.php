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
$upd_user = new User($db);
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
		$user->first_name = $decoded->data->first_name;
		$user->last_name = $decoded->data->last_name;
		$user->user_org_name = $decoded->data->user_org_name;
		$user->user_id = $decoded->data->user_id;
		$user->user_role = $decoded->data->user_role;
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
        "error" => $e->getMessage()
    ));
}
if($user->user_role=='RTC' || $user->user_id==$upd_user->user_id)
{
// set user property values
$upd_user->first_name = $data->first_name;
$upd_user->last_name = $data->last_name;
$upd_user->user_org_name = $data->user_org_name;
$upd_user->password = $data->password;
$upd_user->user_id = $data->user_id;
$upd_user->user_mobile = $data->user_mobile;
$upd_user->user_desc = $data->user_desc;
$upd_user->user_mrtc_id = $data->user_mrtc_id;
$upd_user->user_role = $data->user_role;
 
// update user will be here
// update the user record

if($upd_user->update()){
    // regenerate jwt will be here
// we need to re-generate jwt because user details might be different
$token = array(
   "iss" => $iss,
   "aud" => $aud,
   "iat" => $iat,
   "nbf" => $nbf,
   "data" => array(
       "user_id" => $user->user_id,
        "first_name" => $user->first_name,
        "last_name" => $user->last_name,
        "user_org_name" => $user->user_org_name,
		"user_role" => $user->user_role   )
);
$jwt = JWT::encode($token, $key);
 
// set response code
http_response_code(200);
 
// response in json format
echo json_encode(
        array(
            "message" => "User was updated.",
            "jwt" => $jwt
        )
    );
}
 
// message if unable to update user
else{
    // set response code
    http_response_code(401);
 
    // show error message
    echo json_encode(array("message" => "Unable to update user."));
}
}
else
{
	 http_response_code(401);
 
    // show error message
    echo json_encode(array(
        "message" => "Access denied."
        
    ));
}
}
?>