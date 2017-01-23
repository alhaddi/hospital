<?php
 
require APPPATH . '/libraries/REST_Controller.php';
 
class Consultation extends REST_Controller {
 
    function __construct($config = 'rest') {
        parent::__construct($config);
    }
 
    // show data mahasiswa
    function index_get() {
        $rm = $this->get('MRN_Number');
		if($rm){
        $id_pasien=$this->db->query("SELECT id FROM ms_pasien WHERE rm='$rm'")->row_array();
			if(!empty($id_pasien['id'])){
			$this->db->from("trs_konsultasi");
			$this->db->where("ms_pasien.id",$id_pasien['id']);
			$list = $this->db->select('
				trs_konsultasi.id as ID_Consuntation,
				trs_konsultasi.id_anamesa as ID_Anamesa,
				ms_pasien.rm MRN_Number,
				ms_pasien.nama_lengkap Patient_Name,
				ms_pasien.no_identitas IC_Number,
				ms_cara_bayar.nama as Category,
				ms_jenis_appointment.nama as Appointment_Type,
				ms_poliklinik.nama as Polyclinic,
				ms_poliklinik.id as ID,
				trs_konsultasi.status,
				trs_konsultasi.add_time
			')
			->join('trs_anamesa','trs_konsultasi.id_anamesa = trs_anamesa.id','inner')
			->join('trs_appointment','trs_anamesa.id_appointment = trs_appointment.id','inner')
			->join('ms_jenis_appointment','trs_appointment.id_jenis_appointment = ms_jenis_appointment.id','inner')
			->join('ms_pasien','trs_appointment.id_pasien = ms_pasien.id','inner')
			->join('ms_cara_bayar','trs_appointment.id_cara_bayar = ms_cara_bayar.id','inner')
			->join('ms_poliklinik','trs_appointment.id_poliklinik = ms_poliklinik.id','inner')
			->get()->result();
				if(count($list) > 0){
					$this->response($list, 200);
				}else{
				$data 	= array(
						'status' => true,
						'message' => 'Consultation not found'
					);
					
					$response['responseData']['results'][0] = $data;
					$this->response($response, REST_Controller::HTTP_NOT_FOUND);
				}
			}else{
			$data 	= array(
					'status' => FALSE,
					'message' => 'MRN Number is not valid !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND);
			}
		}else{
			$data 	= array(
					'status' => FALSE,
					'message' => 'MRN Number cannot be null !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND);
		}
    }
	
	function vitalsign_get(){
		
		$ID_Anamesa=$this->get("ID_Anamesa");
		if($ID_Anamesa != ""){
		$list = $this->db->select('
			ms_komponen_anamesa.nama_inggris as Vital_Sign,
			ms_komponen_anamesa.satuan as Unit,
			trs_anamesa_detail.hasil as Value,
			')
			->where('id_anamesa',$ID_Anamesa)
			->join('ms_komponen_anamesa','ms_komponen_anamesa.id = trs_anamesa_detail.id_ms_anamesa','inner')
			->get('trs_anamesa_detail')->result();
				if(count($list) > 0){
					$this->response($list, 200);
				}else{
				$data 	= array(
						'status' => true,
						'message' => 'Consultation not found'
					);
					
					$response['responseData']['results'][0] = $data;
					$this->response($response, REST_Controller::HTTP_NOT_FOUND);
				}
		}else{
			$data 	= array(
					'status' => FALSE,
					'message' => 'ID Anamesa cannot be null !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND);
		}	
		
	}
	
	function diagnosis_get(){
		
		$id=$this->get("ID_Consultation");
		if($id != ""){
		$list = $this->db->select('
			trs_diagnosa.code as Code,
			trs_diagnosa.type as Type,
			tb_data_icd.deskripsi as Description,
			trs_diagnosa.catatan as Record
			')
			->where('trs_diagnosa.id_konsultasi',$id)
			->join('tb_data_icd','tb_data_icd.code = trs_diagnosa.code','inner')
			->get('trs_diagnosa')->result();
				if(count($list) > 0){
					$this->response($list, 200);
				}else{
				$data 	= array(
						'status' => true,
						'message' => 'Diagnosis not found'
					);
					
					$response['responseData']['results'][0] = $data;
					$this->response($response, REST_Controller::HTTP_NOT_FOUND);
				}
		}else{
			$data 	= array(
					'status' => FALSE,
					'message' => 'ID_Consultation cannot be null !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND);
		}	
		
	}
	function procedure_get(){
		
		$id=$this->get("ID_Consultation");
		if($id != ""){
			$list = $this->db->select('

			trs_tindakan.keterangan as Information,
			ms_tindakan.nama as Action
			')
			->where('trs_tindakan.id_konsultasi',$id)
			->join('ms_tindakan','ms_tindakan.id = trs_tindakan.id_ms_tindakan','inner')
			->get('trs_tindakan')->result();
				if(count($list) > 0){
					$this->response($list, 200);
				}else{
				$data 	= array(
						'status' => true,
						'message' => 'Procedure not found'
					);
					
					$response['responseData']['results'][0] = $data;
					$this->response($response, REST_Controller::HTTP_NOT_FOUND);
				}
		}else{
			$data 	= array(
					'status' => FALSE,
					'message' => 'ID_Consultation cannot be null !'
				);
				
				$response['responseData']['results'][0] = $data;
				$this->response($response, REST_Controller::HTTP_NOT_FOUND);
		}	
		
	}
}