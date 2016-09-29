<?php

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/db_connect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
		
		
    }

    // creating new user if not existed
    public function createUser($name, $email) {
        $response = array();

        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // insert query
            $stmt = $this->conn->prepare("INSERT INTO users(name, email) values(?, ?)");
            $stmt->bind_param("ss", $name, $email);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                $response["error"] = false;
                $response["user"] = $this->getUserByEmail($email);
            } else {
                // Failed to create user
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registereing";
            }
        } else {
            // User with same email already existed in the db
            $response["error"] = false;
            $response["user"] = $this->getUserByEmail($email);
        }

        return $response;
    }

    // updating user GCM registration ID
    public function updateGcmID($user_id, $gcm_registration_id) {
        $response = array();
        $stmt = $this->conn->prepare("UPDATE api_andro_notif SET gcm_registration_id = ? WHERE user_id = ?");
        $stmt->bind_param("si", $gcm_registration_id, $user_id);

        if ($stmt->execute()) {
            // User successfully updated
            $response["error"] = false;
            $response["message"] = 'GCM registration ID updated successfully';
        } else {
            // Failed to update user
            $response["error"] = true;
            $response["message"] = "Failed to update GCM registration ID";
            $stmt->error;
        }
        $stmt->close();

        return $response;
    }

    // fetching single user by id
    public function getUser($user_id) {
        $stmt = $this->conn->prepare("SELECT user_id, name, email, gcm_registration_id, created_at FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($user_id, $name, $email, $gcm_registration_id, $created_at);
            $stmt->fetch();
            $user = array();
            $user["user_id"] = $user_id;
            $user["name"] = $name;
            $user["email"] = $email;
            $user["gcm_registration_id"] = $gcm_registration_id;
            $user["created_at"] = $created_at;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    // fetching multiple users by ids
    public function getUsers($user_ids) {

        $users = array();
        if (sizeof($user_ids) > 0) {
            $query = "SELECT user_id, name, email, gcm_registration_id, created_at FROM users WHERE user_id IN (";

            foreach ($user_ids as $user_id) {
                $query .= $user_id . ',';
            }

            $query = substr($query, 0, strlen($query) - 1);
            $query .= ')';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($user = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["user_id"] = $user['user_id'];
                $tmp["name"] =    $user['name'];
                $tmp["email"] =   $user['email'];
                $tmp["gcm_registration_id"] = $user['gcm_registration_id'];
                $tmp["created_at"] = $user['created_at'];
                array_push($users, $tmp);
            }
        }

        return $users;
    }

    // messaging in a chat room / to persional message
    public function addMessage($user_id, $chat_room_id, $message) {
        $response = array();

        $stmt = $this->conn->prepare("INSERT INTO messages (chat_room_id, user_id, message) values(?, ?, ?)");
        $stmt->bind_param("iis", $chat_room_id, $user_id, $message);

        if ($result = $stmt->execute()) {
            $response['error'] = false;
            // get the message
            $message_id = $this->conn->insert_id;
            $stmt = $this->conn->prepare("SELECT message_id, user_id, chat_room_id, message, created_at FROM messages WHERE message_id = ?");
            $stmt->bind_param("i", $message_id);
            if ($stmt->execute()) {
                $stmt->bind_result($message_id, $user_id, $chat_room_id, $message, $created_at);
                $stmt->fetch();
                $tmp = array();
                $tmp['message_id'] = $message_id;
                $tmp['chat_room_id'] = $chat_room_id;
                $tmp['message'] = $message;
                $tmp['created_at'] = $created_at;
                $response['message'] = $tmp;
            }
        } else {
            $response['error'] = true;
            $response['message'] = 'Failed send message ' . $stmt->error;
        }

        return $response;
    }

    // fetching all chat rooms
    public function getAllChatrooms() {
        $stmt = $this->conn->prepare("SELECT * FROM chat_rooms");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    // fetching single chat room by id
    function getChatRoom($chat_room_id) {
        $stmt = $this->conn->prepare("SELECT cr.chat_room_id, cr.name, cr.created_at as chat_room_created_at, u.name as username, c.* FROM chat_rooms cr LEFT JOIN messages c ON c.chat_room_id = cr.chat_room_id LEFT JOIN users u ON u.user_id = c.user_id WHERE cr.chat_room_id = ?");
        $stmt->bind_param("i", $chat_room_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT user_id from users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Fetching user by email
     * @param String $email User email id
     */
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT user_id, name, email, created_at FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($user_id, $name, $email, $created_at);
            $stmt->fetch();
            $user = array();
            
            $user["user_id"] = $user_id;
            $user["name"] = $name;
            $user["email"] = $email;
            $user["created_at"] = $created_at;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
    *
    * @param Sring username password
    */
    public function getUsernPasswd($uname,$password){       
        $response=array();
        $stmt =$this->conn->prepare("SELECT user_id,username,email FROM api_andro_notif WHERE  username= ? AND password= ? ");
        $stmt->bind_param("ss",$uname,$password);

        if ($stmt->execute()){
            $stmt->bind_result($id,$name,$email);  
            $stmt->fetch();  

            $users = array();
            $response["error"] = false;
            $users["uid"]      = $id;
            $users["name"]     = $name;
            $users["mail"]     = $email;
            $response["user"]  = $users;
            $stmt->close();

        }else{
            $response["error"] = true;
            $response['message'] = 'Failed To Login'. $stmt->error;
        }
        return $response;
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

    /**
    * @param nip,email,Jenis_cuti,tglmulai,tgl_akhir,lamanya,alamat selama cuti,
    *        keterangan,Atasan Langsung,list persyaratan        
    */

    public function createIzincuti($nip,$nama,$telp,$email,$id_user){
        $response=array();
        $stmt = $this->conn->prepare("INSERT INTO tr_transaksi (kode_usulan,kode_layanan,status,nip,nama,telp,email,waktu_usulan,id_user_usul)  values (?,?,?,?,?,?,?,?,?) ");
        $kode_usulan=$this->generateKodeUsulan();
        $kode_layanan="17";
        $waktu_usulan=date('Y-m-d H:i:s');

    $stmt->bind_param("ssisssssi",$kode_usulan,$kode_layanan,$status,$nip,
    $nama,$telp,$email,$waktu_usulan,$id_user);
    $result = $stmt->execute();
    $stmt->close();
            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                $response["status"]  = true;
                $response["message"] = "Data Berhasil Ditambahkan";
                $response["nip"]     = $nip;
            } else {
                // Failed to create user
                $response["status"]   = false;
                $response["message"] = "Oops! An error occurred while registereing";
            }
            return $response;
    }

    private function generateKodeUsulan(){
       $count=$this->cekLastKode();
        if ($count == 0) {
            $genkey  ="0001";    
        }else{
             $genkey=$this->cekLastKode();
        }
        $kode_usulan ="17".$genkey.date('m').date('Y');
        return $kode_usulan;
    }

    public function cekLastKode(){
        $query="SELECT MAX(MID(kode_usulan,3,4)) AS code
                            FROM tr_transaksi 
                            WHERE MID(kode_usulan,1,2)='17'
                            AND MID(kode_usulan,7,2)='".date('m')."' 
                            AND MID(kode_usulan,9,4)='".date('Y')."' ";
        $stmt=$this->conn->prepare($query);
        $stmt->execute();
        $stmt->bind_result($code);  
        $stmt->fetch();  
        //hasil masih utuh belum dipecah
        $h_usulan = $code; 
        $result = $this->GenerateNoUsulan($h_usulan);
        return $result;
    }

    private function GenerateNoUsulan($kode){
        $no_nota='';
        $no_nota=$kode+1;
        switch (strlen($no_nota)) {
            case 1:$no_nota='000'.$no_nota;
                break;
            case 2:$no_nota='00'.$no_nota;
                break;
            case 3:$no_nota='0'.$no_nota;
                break;
            case 4:$no_nota=$no_nota;
                break;
            default:
                # code...
                break;
        }
        return $no_nota;
    }

	/**
    * Menampilkan cuti berdasarkan nip pegawai
    * @param $nip
    */
	public function getStatusCuti($nip_pegawai){
		$response = array(); 
        $stmt = $this->conn->prepare("SELECT id,kode_usulan,nama,status 
                                      FROM tr_transaksi WHERE kode_layanan=?");
        $stmt->bind_param("s", $nip_pegawai);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        $res=$tasks->num_rows;
    
    if(!empty($res)){ 
        $response["status"]  = true;
        $response["message"] = "Data Berhasil Di Load";         
        $response['data']    = array();
        while ($chat_room=$tasks->fetch_assoc())
            {
                $cmt = array();
                $cmt["kode_usulan"]  = $chat_room["kode_usulan"];
                $cmt["nama"]         = $chat_room["nama"];
                $cmt["status_cuti"]  = $chat_room["status"];
                array_push($response["data"], $cmt);
            }

        }else{
            $response["status"]  = false;
            $response["message"] = "Tidak Ada Data";
        }
        return $response ;
	}

    /**
    * menampilkan sisa cuti berdasarkan batasan max cuti
    *@param $nip
    */
    public function getSisaCuti($nip){
            $stmt = $this->conn->prepare("SELECT * FROM tr_transaksi WHERE nip=?");
        $stmt->bind_param("i", $nip);
        $stmt->execute();
        $sisacuti = $stmt->get_result();
        $stmt->close();
        
        return $sisacuti;
    }

}

?>
