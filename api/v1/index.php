<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../include/db_handler_simpeg.php';
require_once '../include/db_handler.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User login
$app->get('/user/login/:nip/:password', function($nip,$password) use ($app) {
    // check for required params
    // verifyRequiredParams(array('nip', 'password'));
          $db_s = new DbHandlerSimpeg();
          $response = array();           
       // get the user by nip
          $user = $db_s->getUsernPasswd($nip,$password);
                if ($user != NULL) {
                    $response["status"]    = false;
                    $response["message"]  ="Login Berhasil";

                    $response['id']       = $user['id'];
                    $response['namapeg'] = $user['username'];
                    $response['nip']      = $user['nip'];
                    $response['token']    = $user['token'];
                } else {
                    // unknown error occurred
                    $response['status']   = true;
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
    echoRespnse(200, $result);
});

$app->get('/sisacuti/:id/', function() use ($app){
     global $app;
    $db = new DbHandler();
    $result           = $db->getSisaCuti($nip);
    $response['cuti'] = array();
    echo "Hello".$nip;
});

$app->get('/cekusulan/:id/', function($nip){
    global $app;
    $db        = new DbHandler();
    $result    = $db->cekLastKode();
    echo $result;
});

/**
*
*
*/
$app->post('/createcuti', function() use ($app) {

    $id_user   = $app->request->post('id');  
    $nama      = $app->request->post('nama');
    $nip       = $app->request->post('nip');
    $telp      = $app->request->post('telp');  
    $email     = $app->request->post('email');


    $nip_atasan     = $app->request->post('nip_atasan');
    $atasan_nama    = $app->request->post('nama_atasan');
    $jabatan_atasan = $app->request->post('jabatan');
    $keterangan     = $app->request->post('keterangan');
    $tmulai         = $app->request->post('tmulai');
    $takhir         = $app->request->post('takhir');
    $jeniscuti      = $app->request->post('jcuti');
    
    $db = new DbHandler();
    $response = $db->createIzincuti($nip,$nama,$telp,$email,$keterangan,$atasan_nama,
        $nip_atasan,$tmulai,$takhir,$jeniscuti,$id_user);
    // echo json response
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
