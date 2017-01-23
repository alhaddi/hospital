<?php
 
require APPPATH . '/libraries/REST_Controller.php';
 
class Patient extends REST_Controller {
 
   function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, DELETE"); //GET, POST, OPTIONS, PUT, DELETE
	}
 
    // show data mahasiswa
    function index_get() {
        $rm = $this->get('MRN_Number');
		$w="";
        if ($rm != '') {
			$w=" AND a.rm='$rm'";
        }
		$pasien = $this->db->query("SELECT
					a.id,
					a.rm as MRN_Number,
					ms_cara_bayar.nama as Category,
					a.nama_lengkap as `Name`,
					a.no_identitas as IC_Number,
					a.usia as Age,
					a.status_menikah as `Status`,
					a.alamat as Address,
					a.tlp as Emergency_Contact,
					a.hp as Mobile,
					a.jk as Sex,
					a.tanggal_lahir as Date_of_Date,
					ms_pekerjaan.nama as Occupation,
					a.nama_orangtua as Mother_Name,
					a.email as Email,
					a.tlp as Phone,
					a.golongan_darah as Blood_Type,
					a.IC_Number as Inscurance_Number,
					a.IC_Number as Inscurance_Number,
					a.telp_emergency as Emergency_Contact,
					a.nama_ayah as Father_name
					FROM
					ms_pasien AS a
					INNER JOIN trs_appointment ON trs_appointment.id_pasien = a.id
					INNER JOIN ms_cara_bayar ON trs_appointment.id_cara_bayar = ms_cara_bayar.id
					INNER JOIN ms_pekerjaan ON a.id_pekerjaan = ms_pekerjaan.id
					WHERE a.rm !='' $w
					")->result();
				if(count($pasien) > 0){
					$this->response($pasien, 200);
				}else{
				$data 	= array(
						'status' => true,
						'message' => 'Patient not found'
					);
					
					$response['responseData']['results'][0] = $data;
					$this->response($response, REST_Controller::HTTP_NOT_FOUND);
				}
    }

}
?>