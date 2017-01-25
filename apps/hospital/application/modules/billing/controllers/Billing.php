<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Billing Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Billing_model');
		$config['table'] = 'trs_billing';
		$config['column_order'] = array(
			null,
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'ms_komponen_registrasi.nama',
			'trs_billing.nominal',
			'trs_billing.add_time',
			'trs_billing.status',
			'trs_billing.last_update',
			null
		);
		
			
		$config['column_search'] = array(
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_pasien.tipe_identitas',
			'ms_pasien.no_identitas',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'trs_billing.status',
			'trs_billing.nominal',
			'trs_billing.add_time'
		);
		$config['column_excel'] = array(
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_pasien.tipe_identitas',
			'ms_pasien.no_identitas',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'trs_billing.status',
			'trs_billing.nominal',
			'trs_billing.add_time'
		);
		$config['column_pdf'] = array(
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_pasien.tipe_identitas',
			'ms_pasien.no_identitas',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'trs_billing.status',
			'trs_billing.nominal',
			'trs_billing.add_time'
		);
		$config['order'] = array('trs_billing.status' => 'ASC','trs_billing.last_update' => 'DESC');
		$this->Billing_model->initialize($config);
    }

    public function index()
    {
		$p = $this->input->get('p');
		$data['title'] = 'Billing';
		$data['id_table'] = 'billing_tbl';
		$data['datatable_list'] = 'billing/ajax_list/'.$p;
		$data['datatable_edit'] = 'billing/ajax_edit';
		$data['datatable_delete'] = 'billing/ajax_delete';
		$data['datatable_save'] = 'billing/ajax_save';
		$data['cara_bayar'] = $this->db->get('ms_cara_bayar')->result_array();
		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		
		$data['load_form'] = $this->load_form($data);
		

		$this->template->display('billing',$data);
    }
	
	
    public function load_form($data)
	{
		$data['id_table']="billing_tbl";
		$data['jenis_bayar'] = $this->db->get('ms_jenis_bayar')->result_array();
		return $this->load->view('form_billing',$data,true);
	}
	
	public function pembayaran(){
		$p = $this->input->get('p');
		
		$post = $this->input->post(NULL,TRUE);
			$billing = $this->db->select('
			trs_billing.id,
			trs_billing.id_appointment,
			ms_komponen_registrasi.nama as nama_komponen,
			trs_billing.nominal as total_bayar
		')
		->where('trs_billing.id',element('id',$post))
		->join('ms_komponen_registrasi','ms_komponen_registrasi.id = trs_billing.id_komponen','inner')
		->get('trs_billing')->row_array();
		
		if(!empty($billing))
		{
			$billing = array_filter($billing);
		}
		echo json_encode($billing);
	}
	function addpoli($id=0){
		$data['id_billing'] = $id;
		$cekpoli=$this->db->query("SELECT b.id_poliklinik FROM trs_billing a,trs_appointment b WHERE a.id_appointment=b.id AND a.id='$id'")->row();
		$this->db->where("id !=",$cekpoli->id_poliklinik);
		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
		$names = array(1,2,3);
		$this->db->where_in("id",$names);
		$this->db->order_by("id","DESC");
		$data['id_komponen_registrasi'] = $this->db->get('ms_komponen_registrasi')->result_array();
		$this->load->view('form_poli',$data);
	}

	function editpoli($id=0){
		$data['id_billing'] = $id;
		$data['cekpoli']=$this->db->query("SELECT b.id_poliklinik,b.id_cara_bayar,b.id FROM trs_billing a,trs_appointment b WHERE a.id_appointment=b.id AND a.id='$id'")->row();

		$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();

		$data['cara_bayar'] = $this->db->get('ms_cara_bayar')->result_array();
		$this->load->view('form_edit_poli',$data);
	}
	function saveeditpoli(){
		$post = $this->input->post(NULL,TRUE);
		$data['id_cara_bayar']=element('id_cara_bayar',$post);
		$data['id_poliklinik']=element('id_poliklinik',$post);
		$this->db->where('id',element('id_appoinment',$post));
		$this->db->update('trs_appointment',$data);
		
		echo json_encode(array("status" => true));
	}
	
	public function save_pembayaran(){
		$post = $this->input->post(NULL,TRUE);
		$update['id_jenis_bayar'] = element('id_jenis_bayar',$post);
		$update['total_bayar'] = rupiah_to_number(element('total_bayar',$post));
		$update['keterangan'] = element('keterangan',$post);
		$update['status'] = 1;
		$update = array_string_to_null($update);
		$id_billing=element('id',$post);
		$billing	= $this->db->query("SELECT id_appointment FROM trs_billing WHERE id='".$id_billing."'")->row_array();
		$app		= $this->db->query("SELECT id_pasien FROM trs_appointment WHERE id='".$billing['id_appointment']."'")->row_array();

		$this->db->where('id',element('id',$post))->update('trs_billing',$update);
		
		if($this->db->affected_rows() > 0 )
		{
			$anamesa['id_appointment'] = element('id_appointment',$post);
			$this->db->insert('trs_anamesa',$anamesa);
			$idd=$this->db->insert_id();
			
			$data_konsultasi['id_anamesa'] = $idd;
			$this->db->insert('trs_konsultasi',$data_konsultasi);
		}
		echo json_encode(array("status" => true,"id_pasien"=>$app['id_pasien'],"id_billing"=>$id_billing));
	}

	
	public function save_poliklinik_pasien(){
		$post = $this->input->post(NULL,TRUE);
		$billing	= $this->db->query("SELECT id_appointment,id_billing_before FROM trs_billing WHERE id='".$post['id_billing']."'")->row_array();
		$app		= $this->db->query("SELECT * FROM trs_appointment WHERE id='".$billing['id_appointment']."'")->row_array();
		$p			= $post['id_komponen_registrasi'];
		
			$insert['id_pasien'] = element('id_pasien',$app);
			$insert['id_jenis_appointment'] = element('id_jenis_appointment',$app);
			$insert['id_appointment_before'] = element('id',$app);
			$insert['id_poliklinik'] = element('id_poliklinik',$post);
			$insert['id_cara_bayar'] = element('id_cara_bayar',$app);
			$insert['id_bpjs_type'] = element('id_bpjs_type',$app);
			$insert['no_bpjs'] = element('no_bpjs',$app);
			$insert['no_polis'] = element('no_bpjs',$app);
			$insert['nama_perusahaan'] = element('nama_perusahaan',$app);
			$insert['id_dokter'] = element('id_dokter',$app);
			$insert['tgl_pertemuan'] = convert_tgl(element('tgl_pertemuan',$app),'Y-m-d H:i:s');
			$insert = array_filter($insert);
			
			$this->db->insert('trs_appointment',$insert);
			$id_appointment = $this->db->insert_id();
			$this->db->where('id',element('id_pasien',$app))->update('ms_pasien',array('arrived_at'=>date('Y-m-d H:i:s')));
			if( $this->db->affected_rows() > 0 )
			{
				$no_tagihan = $this->Billing_model->no_tagihan();
				
				$komponen = $this->db->select('ms_komponen_registrasi.*')
				->get_where('ms_komponen_registrasi',array('id'=>element('id_komponen',$post)))->row_array();
				if(!empty($billing['id_billing_before'])){				
				$cek2xkonsul=$this->db->query("SELECT id FROM trs_billing WHERE id_billing_before='".$billing['id_billing_before']."'")->num_rows();
				}else{
					$cek2xkonsul=0;
				}
					$insert_tagihan['no_tagihan'] = $no_tagihan;
					$insert_tagihan['id_appointment'] = $id_appointment;
					$insert_tagihan['id_komponen'] = $p;
					$insert_tagihan['nominal'] = get_field($p,'ms_komponen_registrasi','nominal');
					$insert_tagihan['total_bayar'] = get_field($p,'ms_komponen_registrasi','nominal');
					$insert_tagihan['`status`'] = 1;
					$insert_tagihan['id_billing_before'] = $post['id_billing'];
					if($cek2xkonsul > 0){
					$insert_tagihan['pindah_poli'] = 'ya';
					}
					
					$this->db->insert('trs_billing',$insert_tagihan);
					$ii=$this->db->insert_id();
					
					$this->db->where('id',$ii);
					$this->db->update('trs_billing',$insert_tagihan);
					
					$up['pindah_poli']='ya';
					$this->db->where('id',$post['id_billing']);
					$this->db->update('trs_billing',$up);
					
					$anamesa['id_appointment'] = $id_appointment;
					$this->db->insert('trs_anamesa',$anamesa);
					$idd=$this->db->insert_id();
			
					$data_konsultasi['id_anamesa'] = $idd;
					$this->db->insert('trs_konsultasi',$data_konsultasi);
			
			$cetak=($app['id_cara_bayar'] != 2)?'cetak':'tidak';
			
			$response = array(
			'status' => true,
			'id_pasien' => element('id_pasien',$app),
			'id_billing' => $ii,
			'cetak' => $cetak,
			'message' => 'Pindah Poli telah selesai di proses !',
			'redirect' => site_url('billing')
			);
			echo json_encode($response);
			
			}
		
	}
    public function ajax_list($id)
	{	
		$list = $this->Billing_model->get_datatables($id);
		
		$data = array();
		$no = $_POST['start'];
		$total = 0;
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $no;
			
			$fields[] = $row->rm;
			$fields[] = "<a style='cursor:pointer;' onclick='modal_edit_poli($row->id);'>".$row->nama_lengkap." <i class='fa fa-pencil'></a></a>";
			$fields[] = $row->cara_bayar;
			$fields[] = $row->poliklinik;
			$fields[] = $row->komponen;
			$fields[] = rupiah($row->nominal);
			$fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			$fields[] = ($row->status == 1)?'<i class="label label-success">Sudah Bayar</i>':'<i class="label label-danger">Belum Bayar</i>';
			$w=($row->pindah_poli == 'ya')?'':' <button onclick="modal_poli('.$row->id.')" type="button" class="btn btn-default" rel="tooltip" title="Daftar ke Poliklinik"><img src="'.FILES_HOST.'img/panah.png"></button>';
			$kwitansi=($row->id_cara_bayar != 2)?'<a href="'.site_url('billing/kwitansi/'.$row->id_pasien.'/'.$row->id).'" target="_BLANK" class="btn btn-default " rel="tooltip" title="Cetak Kwitansi"><i class="fa fa-print"></i></a>':'';
			$fields[] = ($row->status == 1)?
				$kwitansi.$w.' <button type="button" onclick="modal_pembatalan('.$row->id.')" type="button" class="btn btn-danger" rel="tooltip" title="Batalkan"><i class="fa fa-times"></i></button>'
				:
				'<button type="button" onclick="modal_pembayaran('.$row->id.')" type="button" class="btn btn-info" rel="tooltip" title="Pembayaran"><i class="fa fa-money"></i></button> <button type="button" onclick="modal_pembatalan('.$row->id.')" type="button" class="btn btn-danger" rel="tooltip" title="Batalkan"><i class="fa fa-times"></i></button>';
			$data[] = $fields;
			if($row->status == 1){
				$total += $row->nominal;
			}
		}
			$fields = array();
			$fields[] = '';
			
			$fields[] = '';
			$fields[] = '';
			$fields[] = '';
			$fields[] = '';
			$fields[] = '<center><b>Total</b></center>';
			$fields[] = '<b>'.rupiah($total).'</b>';
			$fields[] = '';
			$fields[] = '';
			$fields[] = '';
			
			$data[] = $fields;
			

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Billing_model->count_all($id),
			"recordsFiltered" => $this->Billing_model->count_filtered($id),
			"data" => $data,
		);

		echo json_encode($output);
	}
	
	function pembatalan(){
		$post = $this->input->post(NULL,TRUE);
		$id_appointment=$this->db->query("SELECT id_appointment as id FROM trs_billing WHERE id='".$post['id']."'")->row();
		$date=date("Y-m-d h:i:s");
		$id_pasien=$this->db->query("SELECT id_pasien as id,id_cara_bayar FROM trs_appointment WHERE id='".$id_appointment->id."'")->row();
		$hap='n';
			if($id_pasien->id_cara_bayar == 2){

				$pas=$this->db->query("SELECT no_sep,ppkPelayanan FROM ms_pasien WHERE id='".$id_pasien->id."'")->row_array();
				
				if(!empty($pas['no_sep'])){
					$no_sep=$pas['no_sep'];
					$ppkPelayanan=$pas['ppkPelayanan'];
					
				}else{
					$date=date("Y-m-d");
					$g=$this->db->query("SELECT * FROM riwayat_sep WHERE add_time LIKE '%$date%' and id_pasien='".$id_pasien->id."' LIMIT 1")->row();
					$no_sep=$g->no_sep;
					$ppkPelayanan=$g->ppkPelayanan;
					$hap='y';
				}
				if(!empty($no_sep)){
				$head=header_bpjs(); //FUNGSI BUAT AMBIL HEADER ADA DI get_field helper di core
				$domain=ws_url(); 	// FUNGSI BUAT SETTING DOMAIN WS BPJS ADA DI CONFIG.PHP
				$link=url_bpjs("delete_sep"); //FUNGSI BUAT AMBIL URL KATALOG ADA DI get_field helper di core
				$full_url=$domain.$link->link;
				
					$bpjs["request"]["t_sep"]["noSep"]=$no_sep;
					$bpjs["request"]["t_sep"]["ppkPelayanan"]=$ppkPelayanan;
					$data_json = json_encode($bpjs,JSON_PRETTY_PRINT);
			
				$head[]='Content-Type: application/x-www-form-urlencoded';
				$head[]='Content-Length: ' . strlen($data_json);
			
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $full_url);                                              
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json); 
					curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$json=curl_exec($ch);
					curl_close ($ch);
					$result=json_decode($json);
				}

			}
			else{
				$result=true;
			}
			if($result){
		
		
		$this->db->query("INSERT INTO ms_pasien_batal (rm, foto, IC_Number, nama_ayah, telp_emergency, golongan_darah, id_agama, id_pekerjaan, nama_lengkap, tipe_identitas, no_identitas, jk, tempat_lahir, tanggal_lahir, usia, status_menikah, nama_orangtua, asal_pasien, no_rujukan, rujukan_dari, hp, tlp, email, alamat, rt, rw, id_wilayah, kelurahan, `status`, arrived_at, add_time, last_update, last_user) SELECT rm, foto, IC_Number, nama_ayah, telp_emergency, golongan_darah, id_agama, id_pekerjaan, nama_lengkap, tipe_identitas, no_identitas, jk, tempat_lahir, tanggal_lahir, usia, status_menikah, nama_orangtua, asal_pasien, no_rujukan, rujukan_dari, hp, tlp, email, alamat, rt, rw, id_wilayah, kelurahan, `status`, arrived_at, '".$date."', '".$date."', last_user FROM `ms_pasien` WHERE id='".$id_pasien->id."' ");
		$idp=$this->db->insert_id();
		
		$this->db->query("INSERT INTO trs_appointment_batal (id_pasien, id_poliklinik, id_cara_bayar, id_jenis_appointment, no_bpjs, id_bpjs_type, no_polis, nama_perusahaan, id_dokter, tgl_pertemuan, add_time, last_update, last_user) SELECT '$idp', id_poliklinik, id_cara_bayar, id_jenis_appointment, no_bpjs, id_bpjs_type, no_polis, nama_perusahaan, id_dokter, tgl_pertemuan, '".$date."', '".$date."', last_user FROM `trs_appointment` WHERE id='".$id_appointment->id."' ");
		$ida=$this->db->insert_id();
		
		$this->db->query("INSERT INTO trs_billing_batal (id_appointment, id_komponen, id_jenis_bayar, nama_kasir, no_tagihan, nominal, total_bayar, kembalian, `status`, keterangan, id_penunjang, id_ms_penunjang, add_time, last_update) SELECT '$ida', id_komponen, id_jenis_bayar, nama_kasir, no_tagihan, nominal, total_bayar, kembalian, `status`, keterangan, id_penunjang, id_ms_penunjang, '".$date."', '".$date."' FROM `trs_billing` WHERE id='".$post['id']."' ");

		$this->db->where("id",$post['id']);
		$this->db->delete('trs_billing');
		$this->db->where("id",$id_appointment->id);
		if($this->db->delete('trs_appointment')){
			$cek=0;
			$cek=$this->db->query("SELECT id FROM trs_appointment WHERE id_pasien='$id_pasien->id'")->num_rows();
			if($cek == 0){
			$this->db->where("id",$id_pasien->id);
			$this->db->delete('ms_pasien');
			if($hap=='y'){
				$this->db->query("DELETE FROM riwayat_sep WHERE id='$g->id'");
			}
			}
			}
		}
		
		
	}
	
	public function ajax_save()
	{
		$post = $this->input->post(NULL,TRUE);
		$data = array(
			 'id_pasien' => $post['id_pasien'],
			 'id_komponen' => $post['id_komponen'],
			 'no_tagihan' => $post['no_tagihan'],
			 'nominal' => $post['nominal'],
			 'total_bayar' => $post['total_bayar'],
			 'sisa' => $post['sisa'],	
			'last_user'=>$this->session->userdata('username')
		);
			
		if(empty($post['id']))
		{
			$data['add_time'] = date('Y-m-d H:i:s');
			$result = $this->Billing_model->insert($data);
		}
		else
		{
			$result = $this->Billing_model->update(array('id' => $post['id']), $data);
		}
		
		echo json_encode(array("status" => true));
		
	}
  
	public function excel()
	{
		$this->load->library("Excel");

		$query = $this->Billing_model->data_excel("billing");
		$this->excel->export($query);
	}
	
	public function pdf($p)
	{
		$get = $this->input->get(NULL,TRUE);
		$this->load->library("Chtml2pdf");
		$this->load->library("Header_file");
		
		$column_order = array(
			null,
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'ms_komponen_registrasi.nama',
			'trs_billing.nominal',
			'trs_billing.add_time',
			'trs_billing.status',
			'trs_billing.last_update',
			null
		);
		
		$w="";
		$x="";
		$data['header'] = $this->header_file->pdf('100%');
		if(!empty($get['cara_bayar'])){
			$w.=" AND id_cara_bayar='".element('cara_bayar',$get)."'";
		}
		
		if(!empty($get['id_poliklinik'])){
			$w.=" AND id_poliklinik='".element('id_poliklinik',$get)."'";
		}
		
		if(!empty($get['column_order']) || !empty($column_order[$get['column_order']])){
			$x = "ORDER BY ".$column_order[$get['column_order']]." ".$get['dir_order'];
		}else{
			$x = "ORDER BY
				`trs_billing`.`status` ASC,
				`ms_pasien`.`rm` DESC";
		}
		
		$sql = "
			SELECT
				`trs_billing`.`id`,
				`ms_pasien`.`id` AS `id_pasien`,
				`ms_pasien`.`rm`,
				`ms_pasien`.`nama_lengkap`,
				`ms_pasien`.`tipe_identitas`,
				`ms_pasien`.`no_identitas`,
				`ms_cara_bayar`.`nama` AS `cara_bayar`,
				`ms_poliklinik`.`nama` AS `poliklinik`,
				`trs_billing`.`status` AS `status`,
				`trs_billing`.`nominal` AS `nominal`,
				`ms_komponen_registrasi`.`nama` AS `komponen`,
				`trs_billing`.`add_time` AS `add_time`
			FROM
				`trs_billing`
			INNER JOIN `ms_komponen_registrasi` ON `ms_komponen_registrasi`.`id` = `trs_billing`.`id_komponen`
			INNER JOIN `trs_appointment` ON `trs_appointment`.`id` = `trs_billing`.`id_appointment`
			INNER JOIN `ms_pasien` ON `ms_pasien`.`id` = `trs_appointment`.`id_pasien`
			INNER JOIN `ms_cara_bayar` ON `ms_cara_bayar`.`id` = `trs_appointment`.`id_cara_bayar`
			INNER JOIN `ms_poliklinik` ON `ms_poliklinik`.`id` = `trs_appointment`.`id_poliklinik`
			WHERE
				DATE(trs_billing.add_time) >= '".element('tgl1',$get)."'
			AND DATE(trs_billing.add_time) <= '".element('tgl2',$get)."'
			AND `trs_billing`.`total_bayar` > 0
			AND `trs_billing`.`id_komponen` IN (1, 3)
			$w
			$x
			";
		
		$data['query'] = $this->db->query($sql)->result_array();
		$content = $this->load->view('pdf_billing',$data,true);
		$this->chtml2pdf->cetak("P","A4",$content,"Billing","I"); 
	}
	
	public function kwitansi($id_pasien,$id_billing) {
        $this->load->library('fpdf');
        $this->load->library('currency');
		$billing	= $this->db->query("SELECT id_appointment FROM trs_billing WHERE id='".$id_billing."'")->row_array();

		$data['identitas']	= $this->db->get('ms_identitas')->row_array();
        $data['pasien'] 	= $this->db->get_where('ms_pasien',array('id'=>$id_pasien))->row_array();
		$data['poliklinik'] = $this->db->select('id_poliklinik')
							->join('ms_pasien','ms_pasien.id = trs_appointment.id_pasien')
							->where('id_pasien',$id_pasien)->where('trs_appointment.id',$billing['id_appointment'])->get('trs_appointment')->row_array();
        $data['payment'] 	= $this->db->get_where('trs_billing',array('id'=>$id_billing))->row_array();
		$data['penanggung_jawab'] = "R. Ahmad Hudaya";
		$data['nip'] = "196310031986031009";

        $this->load->view('kwitansi', $data);
    }
	
	public function kwitansi2($id_pasien,$id_billing) {
        $this->load->library('fpdf');
        $this->load->library('currency');
		
		$data['identitas']	= $this->db->get('ms_identitas')->row_array();
        $data['pasien'] 	= $this->db->get_where('ms_pasien',array('id'=>$id_pasien))->row_array();
        $data['payment'] 	= $this->db->get_where('trs_billing',array('id'=>$id_billing))->row_array();
		$data['poli']	= $this->db->select('
			ms_poliklinik.nama as nama_poliklinik
		')
		->where('trs_billing.id',$id_billing)
		->join('ms_poliklinik','ms_poliklinik.id = trs_appointment.id_poliklinik','inner')
		->join('trs_billing','trs_billing.id_appointment = trs_appointment.id','inner')
		->get('trs_appointment')->row_array();
		
		$data['penanggung_jawab'] = "R. Ahmad Hudaya";
		$data['nip'] = "196310031986031009";

        $this->load->view('kwitansi2', $data);
    }
}
?>
