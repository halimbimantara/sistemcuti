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

    public function createIzincuti($nip,$nama,$jabatan,$pangkat,$unkerja,$telp,$email,$ket,$atasan_nama,$nip_atasan,$tmulai,$takhir,$jenis_cuti,$id_user,$jabatan_atasan,$alamatcuti){
    $response=array();
    $stmt = $this->conn->prepare("INSERT INTO tr_transaksi (kode_usulan,kode_layanan,status,nip,nama,jabatan,gol_pangkat,unit_kerja,telp,email,waktu_usulan,ket,atas_nama,atas_nip,id_user_usul)  values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
        $kode_usulan=$this->generateKodeUsulan();
        $kode_layanan="17";
        $waktu_usulan=date('Y-m-d H:i:s');
        $status=1;
$stmt->bind_param("ssisssssssssssi",$kode_usulan,$kode_layanan,$status,$nip,$nama,$jabatan,
    $pangkat,$unkerja,$telp,$email,$waktu_usulan,$ket,$atasan_nama,$nip_atasan,$id_user);
    $result = $stmt->execute();
    $stmt->close();
            // Check for successful insertion
    if ($result) {
               //User successfully inserted
               //insert into tr detail 
               $stmts=$this->conn->prepare("INSERT INTO tr_detail_cuti (kode_usulan,tahun,nip,jenis_cuti,jum_hari,sisa_cuti,tmulai,takhir,keterangan,alamat,tgl_pengajuan,nip_atasan,nama_atasan,jabatan_atasan) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $tahun_usulan=date('Y');
      $jum_hari=1;
      $sisacuti=2;
      $alamat=$alamatcuti;
      //kdsop
      $stmts->bind_param("sisiiissssssss",$kode_usulan,$tahun_usulan,$nip,$jenis_cuti,
                $jum_hari,$sisacuti,$tmulai,$takhir,$ket,$alamat,$waktu_usulan,
                $nip_atasan,$atasan_nama,$jabatan_atasan);
      $result = $stmts->execute();
      $stmts->close();
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
        $stmt = $this->conn->prepare("SELECT trx.kode_usulan,trx.nama,trx.waktu_usulan,ct.tmulai,ct.takhir,jc.ncuti jeniscuti,trx.atas_nama,trx.status FROM tr_transaksi trx
            JOIN tr_detail_cuti ct ON ct.kode_usulan=trx.kode_usulan
            JOIN ref_jenis_cuti jc ON jc.kcuti=ct.jenis_cuti
            WHERE trx.nip=?
            ORDER BY trx.waktu_usulan DESC");
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
                $cmt["nama"]  = $chat_room["nama"];
                $cmt["waktu_usulan"] = $chat_room["waktu_usulan"];
                $cmt["tmulai"]       = $chat_room["tmulai"];
                $cmt["takhir"]       = $chat_room["takhir"];
                $cmt["jcuti"]       = $chat_room["jeniscuti"];
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
