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
   
   public function getNipAtasan(){
     $response=array();
        $query="SELECT a.*, 
                    if((length(a.nip) = 9),concat(substr(a.nip,1,3),' ',substr(a.nip,4,3),' ',substr(a.nip,7,3)),concat(substr(a.nip,1,8),' ',substr(a.nip,9,6),' ',substr(a.nip,15,1),' ',substr(a.nip,16,3))) AS nippeg,concat(if(((trim(a.gldepan) = '') or isnull(a.gldepan)),'',concat(a.gldepan,'. ')),a.nama,concat(if(((trim(a.glblk) = '') or isnull(a.glblk)),'',concat(', ',a.glblk)))) AS namapeg,d.kgolru as kgolru_pangkat, d.tmtpang, d.knpang,f.jnsjab, f.kjab, if(f.keselon is null or f.keselon = '',99,f.keselon) as keselon, f.tmtjab, f.njab, g.kinsind, f.jabatan_kcl,
                    g.kuntp, 
                    g.kunkom, 
                    g.kununit, 
                    g.kunsk as ksatker, 
                    g.kunssk as kssatker,
                    concat(g.kuntp,g.kunkom,g.kununit,g.kunsk,g.kunssk) as kunker1,
                    concat(g.kuntp,g.kunkom,g.kununit,'0000') as kunker2,
                    g.kunker,f1.nunker as unit_kerja,
                    concat(d1.pangkat,' (',d1.ngolru,')') as pangkat
                FROM peg_identpeg a
                LEFT JOIN peg_acpns b  ON (a.nip = b.nip)
                LEFT JOIN peg_apns c   ON (a.nip = c.nip)
                LEFT JOIN peg_pakhir d ON (a.nip = d.nip)
                LEFT JOIN peg_gkkhir e ON (a.nip = e.nip)
                LEFT JOIN peg_jakhir f ON (a.nip = f.nip)
                LEFT JOIN peg_tkerja g ON (a.nip = g.nip)
                LEFT JOIN peg_pdakhir h   ON (a.nip = h.nip)
                LEFT JOIN ref_golruang d1 ON (d.kgolru = d1.kgolru)
                LEFT JOIN ref_unkerja f1  ON  (concat(g.kuntp,g.kunkom,g.kununit,g.kunsk,g.kunssk) = f1.kunker)
                WHERE jnsjab=1
                AND a.kstatus=2";

        $stmt = $this->conn->prepare($query);
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
                $cmt["nipatasan"] = $chat_room["nip"];
                $cmt["namapeg"]   = $chat_room["namapeg"];
                array_push($response["data"], $cmt);
            }
        }else{
            $response["status"]  = false;
            $response["message"] = "Tidak Ada Data";
        }
        return $response ;
   }

   public function getBiodata($nip){
        $response=array();
        $query="SELECT a.*, 
                    if((length(a.nip) = 9),concat(substr(a.nip,1,3),' ',substr(a.nip,4,3),' ',substr(a.nip,7,3)),concat(substr(a.nip,1,8),' ',substr(a.nip,9,6),' ',substr(a.nip,15,1),' ',substr(a.nip,16,3))) AS nippeg,concat(if(((trim(a.gldepan) = '') or isnull(a.gldepan)),'',concat(a.gldepan,'. ')),a.nama,concat(if(((trim(a.glblk) = '') or isnull(a.glblk)),'',concat(', ',a.glblk)))) AS namapeg,d.kgolru as kgolru_pangkat, d.tmtpang, d.knpang,f.jnsjab, f.kjab, if(f.keselon is null or f.keselon = '',99,f.keselon) as keselon, f.tmtjab, f.njab, g.kinsind, f.jabatan_kcl,
                    g.kuntp, 
                    g.kunkom, 
                    g.kununit, 
                    g.kunsk as ksatker, 
                    g.kunssk as kssatker,
                    concat(g.kuntp,g.kunkom,g.kununit,g.kunsk,g.kunssk) as kunker1,
                    concat(g.kuntp,g.kunkom,g.kununit,'0000') as kunker2,
                    g.kunker,f1.nunker as unit_kerja,
                    concat(d1.pangkat,' (',d1.ngolru,')') as pangkat
                FROM peg_identpeg a
                LEFT JOIN peg_acpns b  ON (a.nip = b.nip)
                LEFT JOIN peg_apns c   ON (a.nip = c.nip)
                LEFT JOIN peg_pakhir d ON (a.nip = d.nip)
                LEFT JOIN peg_gkkhir e ON (a.nip = e.nip)
                LEFT JOIN peg_jakhir f ON (a.nip = f.nip)
                LEFT JOIN peg_tkerja g ON (a.nip = g.nip)
                LEFT JOIN peg_pdakhir h   ON (a.nip = h.nip)
                LEFT JOIN ref_golruang d1 ON (d.kgolru = d1.kgolru)
                LEFT JOIN ref_unkerja f1  ON  (concat(g.kuntp,g.kunkom,g.kununit,g.kunsk,g.kunssk) = f1.kunker)
                WHERE a.nip=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s",$nip);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        $res=$tasks->num_rows;

        if (!empty($res)) {
            $result=$tasks->fetch_assoc();
            $response["status"]    = true;
            $response["message"]   = "Data Berhasil Di Load";
            $response["namapeg"]   = $result['namapeg'];
            $response["jabatan"]   = $result['njab'];
            $response["pangkat"]   = $result['pangkat'];
            $response["unitkerja"] = $result['unit_kerja'];
            $response["no_hp"]     = $result['alhp'];
            $response["email"]     = $result['alemail'];                    
        }else{
            $response["status"]  = false;
            $response["message"] = "Data Gagal Di Load";
        }
        return $response;
    }
    /**
    *
    * @param Sring username password
    */
    public function getUsernPasswd($uname,$password){       
        $passwords=sha1(md5($password));
        $stmt = $this->conn->prepare("SELECT id_user,nama,nip,photo FROM tb_user 
                                      WHERE `nip`= ? 
                                      AND `password`= ? ");
        $stmt->bind_param("ss",$uname,$passwords);
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
