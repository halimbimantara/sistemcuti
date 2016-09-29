<?php

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class DbHandlerSimpeg {

	private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/db_connect.php';
        // opening db connection
		$db = new DbConnect();
        $this->conn = $db->connect_simpeg();
    }
   
    /**
    *
    * @param Sring username password
    */
    public function getUsernPasswd($uname,$password){       
       
        $stmt = $this->conn->prepare("SELECT id,username,nip,token FROM user 
                                      WHERE `nip`= ? 
                                      AND `password_hash`= ? ");
        $stmt->bind_param("is",$uname,$password);
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return $stmt->error;
        }
    }

    /**
    *
    * @param cek id and save token
    */
    public function saveToken($uid,$name,$token){
    $response=array();
    $stmt =$this->conn->prepare("SELECT key FROM users WHERE  user_id= ? AND name= ? ");
        $stmt->bind_param("is",$uid,$name);
    if($stmt->execute()){
    
    //berhasil cocok
    $stmtinsert = $this->conn->prepare("UPDATE users SET key = ? WHERE user_id = ?");
    $stmtinsert->bind_param("si", $token, $uid);

        if ($stmtinsert->execute()) {
            // User successfully updated
            $response["error"] = false;
            $response["message"] = 'Token Berhasil Di Upload';
        } else {
            // Failed to update user
            $response["error"] = true;
            $response["message"] = "Gagal Upload Token";
            $stmtinsert->error;
        }
        $stmtinsert->close();
        return $response;
    }else{
            //error tidak ditemukan

        }
    }
		
}
?>
