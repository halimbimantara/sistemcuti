<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../include/db_handler_simpeg.php';
require_once '../include/db_handler.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User login
$app->post('/user/login', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('nip', 'password'));

     // reading post params
    $nip     = $app->request->post('nip');
    $password = $app->request->post('password');

          $db_s = new DbHandlerSimpeg();
          $response = array();
            // check for correct email and password
            // if ($db->checkLogin($email, $password)) {
                // get the user by email
          $user = $db_s->getUsernPasswd($nip,$password);
                if ($user != NULL) {
                    $response["error"]    = false;
                    $response['id']       = $user['id'];
                    $response['username'] = $user['username'];
                    $response['nip']      = $user['nip'];
                    $response['token']    = $user['token'];
                } else {
                    // unknown error occurred
                    $response['error']   = true;
                    $response['message'] = "An error occurred. Please try again";
                }
 
            echoRespnse(200, $response);
});

/**
* 
* @param id cuti
*/
$app->get('/status_cuti/:id', function($id_cuti){
	 global $app;
    $db = new DbHandler();
    $result = $db->getStatusCuti($id_cuti);
    $response["error"] = false;
    $response['cuti'] = array();
     // looping through result and preparing tasks array
    while ($chat_room = $result->fetch_assoc()) {
        // adding chart status cuti
        if ($chat_room['id'] != NULL) {
            // message node
            $cmt = array();
            $cmt["kode_usulan"] = $chat_room["kode_usulan"];
            $cmt["nama"]        = $chat_room["nama"];
            $cmt["status"]      = $chat_room["status"];
            array_push($response["cuti"], $cmt);
        }
    }
    echoRespnse(200, $response);
});

$app->get('/sisacuti/:id/', function($nip){
     global $app;
    $db = new DbHandler();
    $result           = $db->getSisaCuti($nip);
    $response['cuti'] = array();
     // looping through result and preparing tasks array
   
       
    echoRespnse(200, $response);
});
 

/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}

function IsNullOrEmptyString($str) {
    return (!isset($str) || trim($str) === '');
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}
$app->run();
?>