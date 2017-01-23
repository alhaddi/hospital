<?php
 
require APPPATH . '/libraries/REST_Controller.php';
 
class Appointment extends REST_Controller {
 
   function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, DELETE"); //GET, POST, OPTIONS, PUT, DELETE
	}
 
    // show data mahasiswa
    function index_get() {
		$no_rm = $this->get('MRN_Number');
		$start = $this->get('Start');
		$end = $this->get('End');
		
		if(empty($no_rm)){
			$response = array(
				'status' => FALSE,
				'message' => 'MRN Number cannot be null !'
			);
			$this->response($response, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
		}
		
		if(empty($start) or empty($end)){
			$response = array(
				'status' => FALSE,
				'message' => 'Please insert start & end date !'
			);
			$this->response($response, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
		}
		
		$query = $this->db->select('
			trs_appointment.id,
			trs_appointment.tgl_pertemuan,
			ms_poliklinik.nama as nama_poliklinik,
			ms_dokter.nama as nama_dokter
		')
		->where('ms_pasien.rm',$no_rm)
		->where('DATE(trs_appointment.tgl_pertemuan) >=',$start)
		->where('DATE(trs_appointment.tgl_pertemuan) <=',$end)
		->join('ms_pasien','ms_pasien.id = trs_appointment.id_pasien','inner')
		->join('ms_poliklinik','ms_poliklinik.id = trs_appointment.id_poliklinik','inner')
		->join('ms_dokter','ms_dokter.id = trs_appointment.id_dokter','inner')
		->get('trs_appointment')->result();
		
		if(empty($query)){
			$response 	= array(
				'status' => FALSE,
				'message' => 'your request data cannot be found !'
			);

			$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		} else {
			foreach($query as $row){
				$data['title'] = $row->nama_dokter .' ['.$row->nama_poliklinik.']';
				$data['start'] = $row->tgl_pertemuan;
				$data['id'] = $row->id;
				$data['allDay'] = false;
				$response[] = $data;
			}
			$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
    }
	
	
	public function index_post(){
		$rm = $this->post('MRN_Number');
		$id_poliklinik = $this->post('ID_Clinic');
		$id_dokter = $this->post('ID_Doctor');
		$tgl_pertemuan = $this->post('Date');
		
		if(empty($rm) or empty($id_poliklinik) or empty($id_dokter) or empty($tgl_pertemuan)){
			$response = array(
				'status' => FALSE,
				'message' => 'Please insert all parameter !'
			);
			$this->response($response, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
		}
		
		$post['rm'] = $rm;
		$post['id_poliklinik'] = $id_poliklinik;
		$post['id_dokter'] = $id_dokter;
		$post['tgl_pertemuan'] = $tgl_pertemuan;
		$post['id_jenis_appointment'] = 1;
		$post['id_cara_bayar'] = 1;
		
		if($this->_save_poliklinik_pasien($post)) {
			$response = array(
				'status' => TRUE,
				'message' => 'Appointment has been added !'
			);
			$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			$response = array(
				'status' => FALSE,
				'message' => 'Add Appointment has been failed !'
			);
			$this->response($response, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
		}
	}
	
	private function _save_poliklinik_pasien($post){
		
		$this->db->trans_start();
			$p = 1;
			
			$pasien = $this->db->select('ms_pasien.id')
			->where('ms_pasien.rm',$post['rm'])
			->get('ms_pasien')->row();
			
			$insert['id_pasien'] = $pasien->id;
			$insert['id_jenis_appointment'] = $post['id_jenis_appointment'];
			$insert['id_poliklinik'] = $post['id_poliklinik'];
			$insert['id_cara_bayar'] = $post['id_cara_bayar'];
			$insert['id_dokter'] = $post['id_dokter'];
			$insert['tgl_pertemuan'] = $post['tgl_pertemuan'];
			$insert = array_filter($insert);
			
			$this->db->insert('trs_appointment',$insert);
			$id_appointment = $this->db->insert_id();
			$this->db->where('id',$pasien->id)->update('ms_pasien',array('arrived_at'=>date('Y-m-d H:i:s')));
			if( $this->db->affected_rows() > 0 )
			{
				
			}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function doctor_get() {
		$query = $this->db->select('
			ms_dokter.id,
			ms_dokter.nama as name
		')
		->get('ms_dokter')->result_array();
		if(empty($query)){
			$response 	= array(
				'status' => FALSE,
				'message' => 'your request data cannot be found !'
			);
			 
			$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
		$response = $query;
		$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	}
	
	function clinic_get() {
		$query = $this->db->select('
			ms_poliklinik.id,
			ms_poliklinik.nama as name
		')
		->get('ms_poliklinik')->result_array();
		if(empty($query)){
			$response 	= array(
				'status' => FALSE,
				'message' => 'your request data cannot be found !'
			);
			 
			$this->response($response, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
		
		$response = $query;
		$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	}
}
?>