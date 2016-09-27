<?php
require_once '../include/db_handler.php';
$db = new DbHandler();
 
// json response array
$response = array();
 
if (isset($_POST['name']) && isset($_POST['password'])) {
 
    // receiving the post params
    $name     = $_POST['name'];
    $password = $_POST['password'];
   
    // get the user by email and password
    $user = $db->getUsernPasswd($name, $password);
       
        echo json_encode($user);
   
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters username or password is missing!";
    echo json_encode($response);
}
?>