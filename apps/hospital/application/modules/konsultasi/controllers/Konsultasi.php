<?php
	/**
		* CodeIgniter Core Model
		*
		* @package         CodeIgniter
		* @subpackage      Controller
		* @category        Konsultasi Controller
		* @author          Amir Mufid
		* @version         1.1
	*/
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Konsultasi extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('Konsultasi_model');
			$this->load->model('billing/Billing_model');
			$config['table'] = 'trs_konsultasi';
			$config['column_order'] = array(
			null,
			
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_pasien.no_identitas',
			'ms_cara_bayar.nama',
			'ms_jenis_appointment.nama',
			'ms_poliklinik.nama',
			'trs_konsultasi.add_time',
			'trs_konsultasi.status',
			null
			);
			$config['column_search'] = array(
			'trs_konsultasi.id',
			'ms_pasien.rm',
			'ms_pasien.nama_lengkap',
			'ms_pasien.tipe_identitas',
			'ms_pasien.no_identitas',
			'ms_cara_bayar.nama',
			'ms_poliklinik.nama',
			'trs_konsultasi.add_time'
			);
			$config['column_excel'] = array(
			'ms_pasien.rm as RM',
			'ms_pasien.nama_lengkap as Nama_Lengkap',
			'concat(ms_pasien.tipe_identitas," ",ms_pasien.no_identitas) as No_Identitas',
			'ms_cara_bayar.nama as Cara_Bayar',
			'ms_poliklinik.nama as Poliklinik',
			'ms_pegawai.nama as dokter',
			'date_format(trs_konsultasi.add_time,"%d %b %Y %H:%i") as Tanggal_Daftar'
			);
			$config['column_pdf'] = array(
			'trs_konsultasi.id as id',
			'ms_pasien.rm as rm',
			'ms_pasien.nama_lengkap nama_lengkap',
			'ms_pasien.tipe_identitas as tipe_identitas',
			'ms_pasien.no_identitas as no_identitas',
			'ms_cara_bayar.nama as cara_bayar',
			'ms_pegawai.nama as dokter',
			'ms_poliklinik.nama as poliklinik',
			'trs_konsultasi.add_time as tgl_daftar'
			);
			$config['order'] = array('trs_konsultasi.status' => 'asc','trs_konsultasi.last_update' => 'desc');
			$this->Konsultasi_model->initialize($config);
		}
		
		public function index()
		{
			$data['title'] = 'Konsultasi';
			$data['id_table'] = 'konsultasi';
			$data['datatable_list'] = 'konsultasi/ajax_list';
			$data['datatable_edit'] = 'konsultasi/ajax_edit';
			$data['datatable_delete'] = 'konsultasi/ajax_delete';
			$data['datatable_save'] = 'konsultasi/ajax_save';
			$this->template->display('konsultasi',$data);
		}
		
		public function detail_konsultasi($id)
		{
			$data['title'] = 'Konsultasi';
			$data['id_table'] = 'konsultasi';
			$data['datatable_save'] = 'konsultasi/pdf_rekam_medis';
			
			$konsultasi	= $this->db->select('
			trs_konsultasi.id,
			trs_konsultasi.id as rowid,
			trs_appointment.id_jenis_appointment,
			trs_appointment.id_cara_bayar,
			ms_cara_bayar.nama as cara_bayar,
			trs_appointment.id_bpjs_type,
			trs_appointment.no_bpjs,
			trs_appointment.no_polis,
			trs_appointment.nama_perusahaan,
			trs_konsultasi.catatan,
			trs_konsultasi.keluhan_pasien,
			trs_konsultasi.kesimpulan,
			trs_konsultasi.kondisi_keluar_pasien,
			trs_konsultasi.status_kondisi_akhir,
			trs_konsultasi.id_anamesa,
			trs_konsultasi.last_update,
			trs_konsultasi.resep,
			ms_pasien.id as id_pasien,
			ms_pegawai.id as id_dokter,
			ms_pegawai.nama as dokter,
			ms_pasien.rm,
			ms_pasien.nama_lengkap,
			ms_pasien.golongan_darah,
			ms_pasien.usia_thn,
			ms_pasien.jk,
			ms_pasien.alamat,
			ms_pasien.tanggal_lahir,
			ms_poliklinik.nama as poliklinik,
			trs_billing.id_ms_penunjang,
			trs_billing.id_komponen
			')
			->where('trs_konsultasi.id',$id)
			->join('trs_anamesa','trs_anamesa.id = trs_konsultasi.id_anamesa','inner')
			->join('ms_pegawai','ms_pegawai.id = trs_anamesa.id_dokter AND ms_pegawai.jenis_pegawai="dokter"','left')
			->join('trs_appointment','trs_appointment.id = trs_anamesa.id_appointment','inner')
			->join('trs_billing','trs_billing.id_appointment = trs_appointment.id','inner')
			->join('ms_cara_bayar','ms_cara_bayar.id = trs_appointment.id_cara_bayar','inner')
			->join('ms_pasien','ms_pasien.id = trs_appointment.id_pasien','inner')
			->join('ms_poliklinik','ms_poliklinik.id = trs_appointment.id_poliklinik','inner')
			->get('trs_konsultasi')->row_array();
			
			$data['anamesa'] = $this->db->select('
			ms_komponen_anamesa.nama,
			ms_komponen_anamesa.satuan,
			ms_komponen_anamesa.icon,
			trs_anamesa_detail.hasil,
			trs_anamesa_detail.id_anamesa,
			trs_anamesa_detail.id_ms_anamesa
			')
			->where('id_anamesa',$konsultasi['id_anamesa'])
			->join('ms_komponen_anamesa','ms_komponen_anamesa.id = trs_anamesa_detail.id_ms_anamesa','inner')
			->get('trs_anamesa_detail')->result_array();
			
			$data['diagnosa'] = $diagnosa = $this->db->select('
			trs_diagnosa.id,
			trs_diagnosa.id as rowid,
			trs_diagnosa.code,
			trs_diagnosa.type,
			ms_icd.deskripsi_ing as deskripsi,
			trs_diagnosa.catatan
			')
			->where('trs_diagnosa.id_konsultasi',$id)
			->join('ms_icd','ms_icd.code = trs_diagnosa.code','inner')
			->get('trs_diagnosa')->result_array();
			
			$data['konsultasi'] = array_merge($konsultasi,$diagnosa);
			
			$data['tindakan'] = $tindakan = $this->db->select('
			trs_tindakan.id,
			trs_tindakan.id as rowid,
			trs_tindakan.jumlah_tindakan as jumlah,
			trs_tindakan.biaya,
			trs_tindakan.keterangan,
			ms_tindakan.id as id_ms_tindakan,
			ms_tindakan.nama
			')
			->where('trs_tindakan.id_konsultasi',$id)
			->join('ms_tindakan','ms_tindakan.id = trs_tindakan.id_ms_tindakan','inner')
			->get('trs_tindakan')->result_array();
			
			$this->template->display('form_detail',$data);
		}
		
		public function pdf_detail_konsultasi($id)
		{
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
					
			$konsultasi	= $this->db->select('
			trs_konsultasi.id,
			trs_konsultasi.id as rowid,
			trs_appointment.id_jenis_appointment,
			trs_appointment.id_cara_bayar,
			ms_cara_bayar.nama as cara_bayar,
			trs_appointment.id_bpjs_type,
			trs_appointment.no_bpjs,
			trs_appointment.no_polis,
			trs_appointment.nama_perusahaan,
			trs_konsultasi.catatan,
			trs_konsultasi.keluhan_pasien,
			trs_konsultasi.kesimpulan,
			trs_konsultasi.kondisi_keluar_pasien,
			trs_konsultasi.status_kondisi_akhir,
			trs_konsultasi.id_anamesa,
			trs_konsultasi.last_update,
			trs_konsultasi.resep,
			ms_pasien.id as id_pasien,
			ms_pegawai.id as id_dokter,
			ms_pegawai.nama as dokter,
			ms_pasien.rm,
			ms_pasien.nama_lengkap,
			ms_pasien.golongan_darah,
			ms_pasien.usia_thn,
			ms_pasien.jk,
			ms_pasien.alamat,
			ms_pasien.tanggal_lahir,
			ms_poliklinik.nama as poliklinik,
			trs_billing.id_ms_penunjang,
			trs_billing.id_komponen
			')
			->where('trs_konsultasi.id',$id)
			->join('trs_anamesa','trs_anamesa.id = trs_konsultasi.id_anamesa','inner')
			->join('ms_pegawai','ms_pegawai.id = trs_anamesa.id_dokter AND ms_pegawai.jenis_pegawai="dokter"','left')
			->join('trs_appointment','trs_appointment.id = trs_anamesa.id_appointment','inner')
			->join('trs_billing','trs_billing.id_appointment = trs_appointment.id','inner')
			->join('ms_cara_bayar','ms_cara_bayar.id = trs_appointment.id_cara_bayar','inner')
			->join('ms_pasien','ms_pasien.id = trs_appointment.id_pasien','inner')
			->join('ms_poliklinik','ms_poliklinik.id = trs_appointment.id_poliklinik','inner')
			->get('trs_konsultasi')->row_array();
			
			$data['anamesa'] = $this->db->select('
			ms_komponen_anamesa.nama,
			ms_komponen_anamesa.satuan,
			ms_komponen_anamesa.icon,
			trs_anamesa_detail.hasil,
			trs_anamesa_detail.id_anamesa,
			trs_anamesa_detail.id_ms_anamesa
			')
			->where('id_anamesa',$konsultasi['id_anamesa'])
			->join('ms_komponen_anamesa','ms_komponen_anamesa.id = trs_anamesa_detail.id_ms_anamesa','inner')
			->get('trs_anamesa_detail')->result_array();
			
			$data['diagnosa'] = $diagnosa = $this->db->select('
			trs_diagnosa.id,
			trs_diagnosa.id as rowid,
			trs_diagnosa.code,
			trs_diagnosa.type,
			ms_icd.deskripsi_ing as deskripsi,
			trs_diagnosa.catatan
			')
			->where('trs_diagnosa.id_konsultasi',$id)
			->join('ms_icd','ms_icd.code = trs_diagnosa.code','inner')
			->get('trs_diagnosa')->result_array();
			
			$data['konsultasi'] = array_merge($konsultasi,$diagnosa);
			
			$data['tindakan'] = $tindakan = $this->db->select('
			trs_tindakan.id,
			trs_tindakan.id as rowid,
			trs_tindakan.jumlah_tindakan as jumlah,
			trs_tindakan.biaya,
			trs_tindakan.keterangan,
			ms_tindakan.id as id_ms_tindakan,
			ms_tindakan.nama
			')
			->where('trs_tindakan.id_konsultasi',$id)
			->join('ms_tindakan','ms_tindakan.id = trs_tindakan.id_ms_tindakan','inner')
			->get('trs_tindakan')->result_array();
			
			
			$data['header'] = $this->header_file->pdf('100%');
			$content = $this->load->view('pdf_rekam_medis',$data,true);
			$this->chtml2pdf->cetak("P","A4",$content,"Konsultasi","I"); 
		}
		
		public function ajax_list()
		{	
			$list = $this->Konsultasi_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $row) {
				$no++;
				$fields = array();
				
				$fields[] = $no;
				$fields[] = $row->rm;
				$fields[] = $row->nama_lengkap;
				$fields[] = $row->tipe_identitas.' '.$row->no_identitas;
				$fields[] = $row->cara_bayar;
				$fields[] = $row->jenis_appointment;
				$fields[] = $row->poliklinik;
				$fields[] = $row->dokter;
				$fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
				$fields[] = ($row->status == 1)?'<i class="label label-success">Sudah</i>':'<i class="label label-danger">Belum</i>';
				$t = '<a href="'.site_url('konsultasi/form_konsultasi/'.$row->id).'" class="btn btn-default"><i class="flaticon-doctor-2"></i> Konsultasi</a>';
				$t .= ($row->status == 1)?'  <a href="'.site_url('konsultasi/detail_konsultasi/'.$row->id).'" class="btn btn-default" _blank><i class="fa fa-table"></i> Detail</a>':'';
				$fields[] = $t;
				
				$data[] = $fields;
			}
			
			$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Konsultasi_model->count_all(),
			"recordsFiltered" => $this->Konsultasi_model->count_filtered(),
			"data" => $data,
			);
			
			echo json_encode($output);
		}
				
		function modal_mr(){
			$post = $this->input->post(NULL,TRUE);
			
			$PasienID=element('PasienID',$post);
			$KonsultasiID=element('KonsultasiID',$post);
			$id=$this->db->query("SELECT
				trs_konsultasi.id,
				ms_poliklinik.nama,
				trs_appointment.add_time
			FROM
			trs_appointment ,
			ms_poliklinik ,
			trs_konsultasi,trs_anamesa,trs_poliklinik
			WHERE trs_anamesa.id_appointment = trs_appointment.id AND trs_konsultasi.id_anamesa = trs_anamesa.id
			AND trs_poliklinik.PoliklinikID = ms_poliklinik.id AND trs_poliklinik.PoliklinikID = trs_appointment.id_poliklinik
			AND
			 trs_appointment.id_pasien = '$PasienID' GROUP BY id_anamesa ORDER BY trs_appointment.add_time DESC
			")->result();
			echo "<div id='detail_mr'><table class='table table-striped table-bordered table-hover'>
					<thead>
					<tr>
						<th style='text-align:center'>No</th>
						<th style='text-align:center'>Poliklinik</th>
						<th style='text-align:center'>Tanggal</th>
						<th style='text-align:center'>Action</th>
					</tr>
					</thead>
						";
						$n=1;
						foreach($id as $r){
							$butt=($KonsultasiID == $r->id)?'<center>-- Sedang dibuka --</center>':"<button onclick='load_mr($r->id)' class='btn btn-info' type='button'>Lihat Riwayat</button>";
						echo "
					<tr>
						<td>$n</td>
						<td>$r->nama</td>
						<td style='text-align:center'>$r->add_time</td>
						<td style='text-align:center'>$butt</td>
					</tr>";
						$n++; }
			echo "</table></div>";
			echo '<center><button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button></center>';
		}
		
		public function form_konsultasi($id,$ket="")
		{
			$data['ket'] = $ket;
			$data['title'] = 'Konsultasi';
			$data['id_table'] = 'konsultasi';
			$data['datatable_save'] = 'konsultasi/ajax_save';
			
			$data['cara_bayar'] = $this->db->select('id,nama')->get('ms_cara_bayar')->result_array();
			
			$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="id_poliklinik IN ($otoritas)";
			$this->db->where($ww);
			}
			$data['poliklinik2'] = $this->db->get('ms_penunjang')->result_array();
			$data['jenis_appointment'] = $this->db->get('ms_jenis_appointment')->result_array();
			$data['bpjs_type'] = $this->db->get('ms_bpjs_type')->result_array();
			$data['ruang'] = $this->db->get('ms_ruang')->result_array();
			$data['kelas'] = $this->db->group_by('kelas')->get('ms_kamar')->result_array();
			
			
			
			$data['konsultasi'] = $konsultasi = $this->db->select('
			trs_konsultasi.id,
			trs_konsultasi.id as rowid,
			trs_appointment.id as id_appointment,
			trs_appointment.id_jenis_appointment,
			trs_appointment.id_cara_bayar,
			trs_appointment.id_bpjs_type,
			trs_appointment.no_bpjs,
			trs_appointment.no_polis,
			trs_appointment.nama_perusahaan,
			trs_konsultasi.catatan,
			trs_konsultasi.keluhan_pasien,
			trs_konsultasi.kesimpulan,
			trs_konsultasi.kondisi_keluar_pasien,
			trs_konsultasi.hamil,
			trs_konsultasi.hamil_ke,
			trs_konsultasi.minggu_ke,
			trs_konsultasi.id_anamesa,
			trs_konsultasi.resep,
			trs_konsultasi.status_kondisi_akhir,
			trs_konsultasi.nama_penanggung_jawab,
			trs_konsultasi.hp,
			trs_konsultasi.id_ruang,
			trs_konsultasi.id_kamar,
			trs_konsultasi.kelas,
			trs_konsultasi.tarif,
			ms_pasien.id as id_pasien,
			ms_pegawai.id as id_dokter,
			ms_pegawai.nama as dokter,
			ms_pasien.rm,
			ms_pasien.nama_lengkap,
			ms_pasien.usia_thn,
			ms_pasien.usia_bln,
			ms_pasien.usia_hari,
			ms_pasien.jk,
			ms_pasien.alamat,
			ms_pasien.tanggal_lahir,
			ms_poliklinik.nama as poliklinik,
			trs_appointment.id_poliklinik
			')
			->where('trs_konsultasi.id',$id)
			->join('trs_anamesa','trs_anamesa.id = trs_konsultasi.id_anamesa','inner')
			->join('ms_pegawai','ms_pegawai.id = trs_anamesa.id_dokter AND ms_pegawai.jenis_pegawai="dokter"','left')
			->join('trs_appointment','trs_appointment.id = trs_anamesa.id_appointment','inner')
			->join('ms_pasien','ms_pasien.id = trs_appointment.id_pasien','inner')
			->join('ms_poliklinik','ms_poliklinik.id = trs_appointment.id_poliklinik','inner')
			->get('trs_konsultasi')->row_array();
			
			
			$this->db->where("id !=",$konsultasi['id_poliklinik']);
			$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
			
			$data['bill']= $this->db->query("SELECT id,pindah_poli FROM trs_billing WHERE id_appointment='".$konsultasi['id_appointment']."'")->row_array();

			
			$data['anamesa'] = $this->db->select('
			ms_komponen_anamesa.nama,
			ms_komponen_anamesa.satuan,
			ms_komponen_anamesa.icon,
			trs_anamesa_detail.hasil,
			trs_anamesa_detail.id_anamesa,
			trs_anamesa_detail.id_ms_anamesa
			')
			->where('id_anamesa',$konsultasi['id_anamesa'])
			->join('ms_komponen_anamesa','ms_komponen_anamesa.id = trs_anamesa_detail.id_ms_anamesa','inner')
			->get('trs_anamesa_detail')->result_array();
			
			$data['diagnosa'] = $diagnosa = $this->db->select('
			trs_diagnosa.id,
			trs_diagnosa.id as rowid,
			trs_diagnosa.code,
			trs_diagnosa.type,
			ms_icd.deskripsi_ing as deskripsi,
			ms_icd.deskripsi_ind,
			trs_diagnosa.catatan
			')
			->where('trs_diagnosa.id_konsultasi',$id)
			->join('ms_icd','ms_icd.code = trs_diagnosa.code','inner')
			->get('trs_diagnosa')->result_array();
			
			$data['tindakan'] = $tindakan = $this->db->select('
			trs_tindakan.id,
			trs_tindakan.id as rowid,
			trs_tindakan.jumlah_tindakan as jumlah,
			trs_tindakan.biaya,
			trs_tindakan.keterangan,
			ms_tindakan.id as id_ms_tindakan,
			ms_tindakan.nama
			')
			->where('trs_tindakan.id_konsultasi',$id)
			->join('ms_tindakan','ms_tindakan.id = trs_tindakan.id_ms_tindakan','inner')
			->get('trs_tindakan')->result_array();
			
			$data['penunjang'] = $tindakan = $this->db->select('
			trs_penunjang.id as rowid,
			trs_penunjang.keterangan as keterangan,
			trs_penunjang.*,
			ms_penunjang.nama as namapenunjang,
			ms_penunjang.biaya as biayapenunjang,
			')->where('trs_penunjang.id_konsultasi',$id)->join('ms_penunjang','ms_penunjang.id = trs_penunjang.id_ms_penunjang','inner')->get('trs_penunjang')->result_array();
			if($otoritas){
			$w=" AND FIND_IN_SET('$otoritas',id_poliklinik)";
			
			}else{
				$w='';
			}
		$data['id_dokter']=$this->db->query('SELECT * FROM ms_pegawai WHERE jenis_pegawai="dokter" '.$w)->result();

			$this->template->display('form_konsultasi',$data);
		}
		public function get_kamar(){
			$post = $this->input->post(null,true);
			$kamar = $this->db->where('kelas',$post['kelas'])->get('ms_kamar')->result_array();
			echo '<option value="">--- Pilih Kamar ---</option>';
			foreach($kamar as $r){
				echo '<option value="'.$r['id'].'">'.$r['nama'].'</option>';
			}
		}
		public function get_tarif_kamar(){
			$post = $this->input->post(null,true);
			$kamar = $this->db->where('id',$post['id'])->get('ms_kamar')->row_array();
			echo $kamar['tarif'];
		}
		public function ajax_edit($id=0)
		{
			$data_object = $this->Konsultasi_model->get_by_id($id);
			if($data_object)
			{
				$list_fields = array(
				'id',
				'id_anamesa',
				'keluhan_pasien',
				'kondisi_keluar_pasien',
				'add_time',
				'last_update',
				);
				
				$fields = $this->Konsultasi_model->list_fields($list_fields);
				$data = (array) $data_object;
				
				foreach($fields as $meta){
					$data_new['name'] = $meta->name;
					$data_new['value'] = $data[$meta->name];
					$data_array[] = $data_new;
				}
				
				$result['status'] = 0;
				$result['data_array'] = $data_array;
				$result['data_object'] = $data_object;
				$response['response'] = $result;
			}
			else
			{
				$result['status'] = 99;
				$response['response'] = $result;
			}
			$this->getbilling($id);
			echo json_encode($response);
		}
		
		public function ajax_save()
		{
			$post = $this->input->post(NULL,TRUE);
			/*if(!empty($post['penunjang']))
			{
				$value = $post['penunjang'];
				foreach($value['id_ms_penunjang'] as $index=>$val)
				{
					$penunjang['id_ms_penunjang'] = $value['id_ms_penunjang'][$index];
					$penunjang['biaya'] = $value['biaya'][$index];
					$penunjang['id_konsultasi'] = element('id',$post);
					$penunjang['id_pasien'] = $value['id_pasien'][$index];
					$penunjang['id_dokter'] = $value['id_dokter'][$index];
					$penunjang['jumlah'] = 1;
					$penunjang['keterangan'] = $value['keterangan'][$index];
					$penunjang_batch[] = $penunjang;
				}
				
				$this->db->replace_batch('trs_penunjang',$penunjang_batch);		
			}
			*/
			if(!empty($post['tindakan']))
			{
				$value = $post['tindakan'];
				foreach($value['id'] as $index=>$val)
				{
					$tindakan['id'] = $value['id'][$index];
					$tindakan['id_ms_tindakan'] = $value['id_ms_tindakan'][$index];
					$tindakan['jumlah_tindakan'] = $value['jumlah'][$index];
					$tindakan['id_konsultasi'] = element('id',$post);
					$tindakan['biaya'] = $value['biaya'][$index];
					$tindakan['keterangan'] = $value['keterangan'][$index];
					$tindakan_batch[] = $tindakan;
				}
				
				$this->db->replace_batch('trs_tindakan',$tindakan_batch);		
				$this->getbilling(element('id',$post));			
			}
			
			if(!empty($post['diagnosa']))
			{
				foreach($post['diagnosa'] as $type=>$item)
				{
					foreach($item['code'] as $index=>$val)
					{
						$diagnosa['id'] = $item['id'][$index];
						$diagnosa['code'] = $item['code'][$index];
						$diagnosa['catatan'] = $item['catatan'][$index];
						$diagnosa['type'] = $type;
						$diagnosa['id_konsultasi'] = element('id',$post);
						$diagnosa_batch[] = $diagnosa;
					}
					
				}
				$this->db->replace_batch('trs_diagnosa',$diagnosa_batch);			
			}
			
			$konsultasi['keluhan_pasien'] = element('keluhan_pasien',$post);
			$konsultasi['kondisi_keluar_pasien'] = element('kondisi_keluar_pasien',$post);
			$konsultasi['kesimpulan'] = element('kesimpulan',$post);
			
			if(strpos($this->session->userdata('id_pol'),'14') !== false){
				$konsultasi['hamil'] = element('hamil',$post);
				$konsultasi['hamil_ke'] = element('hamil_ke',$post);
				$konsultasi['minggu_ke'] = element('minggu_ke',$post);
			}
			$konsultasi['status'] = 1;
			$konsultasi['resep'] = element('resep_txt',$post);
			$konsultasi['status_kondisi_akhir'] = element('status_kondisi_akhir',$post);

			$konsultasi['nama_penanggung_jawab'] = element('nama_penanggung_jawab',$post);
			$konsultasi['hp'] = element('hp',$post);
			$konsultasi['id_ruang'] = element('id_ruang',$post);
			$konsultasi['id_kamar'] = element('id_kamar',$post);
			$konsultasi['kelas'] = element('kelas',$post);
			$konsultasi['tarif'] = element('tarif',$post);
			$konsultasi['catatan'] = element('catatan',$post);
			$this->db->where('id',element('id',$post))->update('trs_konsultasi',$konsultasi);
			
			if(!empty($konsultasi['status_kondisi_akhir'])){
				$pas=$this->db->query("SELECT no_sep,ppkPelayanan FROM ms_pasien WHERE id='".element('id_pasien',$post)."'")->row_array();
				if(!empty($pas['no_sep'])){
				$head=header_bpjs(); //FUNGSI BUAT AMBIL HEADER ADA DI get_field helper di core
				$domain=ws_url(); 	// FUNGSI BUAT SETTING DOMAIN WS BPJS ADA DI CONFIG.PHP
				$link=url_bpjs("update_tglpulang_sep"); //FUNGSI BUAT AMBIL URL KATALOG ADA DI get_field helper di core
				$full_url=$domain.$link->link;
				
					$bpjs["request"]["t_sep"]["noSep"]=$pas['no_sep'];
					$bpjs["request"]["t_sep"]["tglPlg"]=date("Y-m-d h:i:s");
					$bpjs["request"]["t_sep"]["ppkPelayanan"]=$pas['ppkPelayanan'];
					$data_json = json_encode($bpjs,JSON_PRETTY_PRINT);
			
				$head[]='Content-Type: application/x-www-form-urlencoded';
				$head[]='Content-Length: ' . strlen($data_json);
			
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $full_url);                                              
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json); 
					curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$json=curl_exec($ch);
					curl_close ($ch);
					$result=json_decode($json);
				}

			}
			
			$response = array(
			'status' => true,
			'message' => 'Konsulasi telah selesai di proses !',
			'redirect' => site_url('konsultasi')
			);
			echo json_encode($response);
		}
		
		
		public function ajax_delete_diagnosa($icd)
		{
			$post = $this->input->post(NULL,TRUE);
			$diagnosa = $post['diagnosa'][$icd];
			$id = $diagnosa['rowid'];
			//		var_dump($id);
			$this->Konsultasi_model->delete_diagnosa($id);
			echo json_encode(array("status" => TRUE));
			
		}
		
		public function ajax_delete_penunjang()
		{
			$post = $this->input->post(NULL,TRUE);
			$penunjang = $post['penunjang'];
			$id = $penunjang['rowid'];
			//		var_dump($id);
			$im=implode(",",$id);
			$i=$this->db->query("SELECT id_konsultasi FROM trs_penunjang WHERE ID IN ($im) LIMIT 1")->row();
			$this->Konsultasi_model->delete_penunjang($id);
			$this->getbilling($i->id_konsultasi);
			
			echo json_encode(array("status" => TRUE));
			
			
		}
		
		public function ajax_delete_tindakan()
		{
			$post = $this->input->post(NULL,TRUE);
			$tindakan = $post['tindakan'];
			$id = $tindakan['rowid'];
			//		var_dump($id);
			$im=implode(",",$id);
			$i=$this->db->query("SELECT id_konsultasi FROM trs_tindakan WHERE ID IN ($im) LIMIT 1")->row();
			$this->Konsultasi_model->delete_tindakan($id);
			$this->getbilling($i->id_konsultasi);
			
			echo json_encode(array("status" => TRUE));
			
			
		}
		
		public function excel()
		{
			$this->load->library("Excel");
			
			$get = $this->input->get(NULL,TRUE);
			
			$query = $this->Konsultasi_model->data_excel($get['tgl1'],$get['tgl2'],$get['column_order'],$get['dir_order']);
			$this->excel->export($query);
		}
		
		public function pdf()
		{			
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$get = $this->input->get(NULL,TRUE);
			
			$query = $this->Konsultasi_model->data_pdf($get['tgl1'],$get['tgl2'],$get['column_order'],$get['dir_order']);
			$data['header'] = $this->header_file->pdf('100%');
			$data['query'] = $query;
			$content = $this->load->view('pdf_konsultasi',$data,true);
			$this->chtml2pdf->cetak("P","A4",$content,"Konsultasi","I"); 
		}
		
		public function pdf_rekam_medis()
		{
			$post = $this->input->get(NULL,TRUE);
			$this->load->library("Chtml2pdf");
			$this->load->library("Header_file");
			
			$query['rm'] = $post['rm'];
			$query['nama_lengkap'] = $post['nama_lengkap'];
			$query['tanggal_lahir'] = $post['tanggal_lahir'];
			$query['cara_bayar'] = $post['cara_bayar'];
			$query['golongan_darah'] = $post['golongan_darah'];
			$query['alamat'] = $post['alamat'];
			$query['poliklinik'] = $post['poliklinik'];
			$query['dokter'] = $post['dokter'];
			$query['komponen'] = $post['komponen'];
			$query['diagnosa'] = $post['diagnosa'];
			$query['keluhan_pasien'] = $post['keluhan_pasien'];
			$query['pemeriksaan'] = $post['pemeriksaan'];
			$query['alergi_obat'] = $post['alergi_obat'];
			$query['resep'] = $post['resep'];
			$query['kesimpulan'] = $post['kesimpulan'];
			$query['kondisi_keluar_pasien'] = $post['kondisi_keluar_pasien'];
			$query['last_update'] = $post['last_update'];
			$query['usia'] = $post['usia'];
			$query['header'] = $this->header_file->pdf('100%');
			$content = $this->load->view('pdf_rekam_medis',$query,true);
			$this->chtml2pdf->cetak("P","A4",$content,"Konsultasi","I"); 
		}
		
		public function anamesa_edit($id_ms_anamesa,$id_anamesa){
			$post = $this->input->post(NULL,TRUE);
			$update['hasil'] = element('value',$post);
			$this->db
			->where('id_ms_anamesa',$id_ms_anamesa)
			->where('id_anamesa',$id_anamesa)
			->update('trs_anamesa_detail',$update);
		}
		
		public function json_diagnosa()
		{
			$get = $this->input->get(NULL,TRUE);
			$search = strip_tags(trim(element('q',$get)));
			$page = strip_tags(trim(element('page',$get)));
			
			$limit=50;
			$offset=($limit*$page);
			
			$this->db->select('
			ms_icd.code,
			ms_icd.deskripsi_ing as deskripsi,
			ms_icd.deskripsi_ind,
			ms_icd.type
			');
			$this->db->where('type',$get['type']);
			$this->db->group_start(); 
			$this->db->like('ms_icd.code', $search,'both');
			$this->db->or_like('ms_icd.deskripsi_ing', $search,'both');
			$this->db->or_like('ms_icd.deskripsi_ind', $search,'both');
			$this->db->group_end();
			
			if($limit){
				$this->db->limit($limit, $offset);
				
			}
			$data = $this->db->get('ms_icd')->result();
			$found=count($data);
			
			if($found > 0){
				foreach ($data as $key => $value) {
					$data[] = array(
					'id' => $value->code,
					'text' => $value->code.' | '.$value->deskripsi.' | '.$value->deskripsi_ind
					);
				}
				} else {
				$data[] = array(
				'id' => '',
				'text' => 'Data tidak ditemukan.'
				);
			}
			
			$this->db->select('
			COUNT(tb_data_icd.code) as total_row
			',false);	
			$this->db->where('type',$get['type']);
			$total_row = $this->db->get('tb_data_icd')->row();
			
			$result['total_count'] = $total_row->total_row;
			$result['items'] = $data;
			// return the result in json
			echo json_encode($result);
		}
		
		public function json_getbiaya()
		{
			$jumlah=$this->input->post("jumlah");
			$IDTindakan=$this->input->post("IDTindakan");
			$data["hasil"]=get_field($IDTindakan,'ms_tindakan','biaya')*$jumlah;
			echo json_encode($data);
			
		}
		public function json_getbiayapenunjang()
		{
			$jumlah=$this->input->post("jumlah");
			$IDPenunjang=$this->input->post("IDPenunjang");
			$data["hasil"]=get_field($IDPenunjang,'ms_penunjang','biaya')*$jumlah;
			echo json_encode($data);
			
		}
		
		function getbilling($id_konsultasi){
			$cekid=$this->db->query("SELECT
			trs_anamesa.id_appointment
			FROM
			trs_konsultasi
			INNER JOIN trs_anamesa ON trs_konsultasi.id_anamesa = trs_anamesa.id
			WHERE trs_konsultasi.id='$id_konsultasi' LIMIT 1
			")->row();
			
			$cektindakan=$this->db->query("SELECT id FROM trs_billing WHERE id_appointment='$cekid->id_appointment' AND id_komponen='4'")->row();
			
			$cekpenunjang=$this->db->query("SELECT id FROM trs_billing WHERE id_appointment='$cekid->id_appointment' AND id_komponen='5'")->row();
			
			$getbill=$this->db->query("SELECT SUM(biaya) as jumlah FROM trs_tindakan WHERE id_konsultasi='$id_konsultasi'")->row();
			
			$getbill2=$this->db->query("SELECT SUM(biaya) as jumlah FROM trs_penunjang WHERE id_konsultasi='$id_konsultasi'")->row();
			
			if(!empty($cekpenunjang->id)){
				if($getbill2->jumlah <= 0 OR $getbill2->jumlah == "" OR $getbill2->jumlah == NULL){
					$this->db->where('id',$cekpenunjang->id);
					$this->db->delete("trs_billing");
					}else{
					$u['nominal']=$getbill2->jumlah;
					$u = array_filter($u);
					$this->db->where("id",$cekpenunjang->id);
					$this->db->update("trs_billing",$u);
					}	
				}else{
				if($getbill2->jumlah > 0 OR $getbill2->jumlah != "" OR $getbill2->jumlah != NULL){				
				$no_tagihan = $this->db->select('CONCAT(YEAR(NOW()),LPAD(ifnull(max(RIGHT(no_tagihan,5))+1,1),5,0)) as max_no_tagihan',false)
				->where('left(no_tagihan,4) = YEAR(NOW())',null,false)
				->get('trs_billing')->row();
				
				$penunjang_db = $this->db->select('id_penunjang,id_ms_penunjang')->where('id',$id_konsultasi)->get('trs_konsultasi')->row_array();
				
				$i['id_appointment']=$cekid->id_appointment;
				$i['id_komponen']=5;
				$i['id_jenis_bayar']=1;
				$i['no_tagihan']=$no_tagihan->max_no_tagihan;;
				$i['id_penunjang']= $penunjang_db['id_penunjang'];
				$i['id_ms_penunjang']= $penunjang_db['id_ms_penunjang'];
				$i['nominal']=$getbill2->jumlah;
				$i['total_bayar']=0;
				$this->db->insert("trs_billing",$i);
				}
			}
			
			if(!empty($cektindakan->id)){
				if($getbill->jumlah <= 0  OR $getbill->jumlah == "" OR $getbill->jumlah == NULL){
					$this->db->where('id',$cektindakan->id);
					$this->db->delete("trs_billing");
					}else{
					$u['nominal']=$getbill->jumlah;
					$this->db->where("id",$cektindakan->id);
					$this->db->update("trs_billing",$u);
				}	
				}else{
				if($getbill->jumlah > 0  OR $getbill->jumlah != "" OR $getbill->jumlah != NULL){				
				$no_tagihan = $this->db->select('CONCAT(YEAR(NOW()),LPAD(ifnull(max(RIGHT(no_tagihan,5))+1,1),5,0)) as max_no_tagihan',false)
				->where('left(no_tagihan,4) = YEAR(NOW())',null,false)
				->get('trs_billing')->row();
				
				$i['id_appointment']=$cekid->id_appointment;
				$i['id_komponen']=4;
				$i['id_jenis_bayar']=1;
				$i['no_tagihan']=$no_tagihan->max_no_tagihan;
				$i['nominal']=$getbill->jumlah;
				$i['total_bayar']=0;
				$this->db->insert("trs_billing",$i);
				}
			}
		}
		
		public function json_tindakan($poli ="")
		{
			$get = $this->input->get(NULL,TRUE);
			$search = strip_tags(trim(element('q',$get)));
			$page = strip_tags(trim(element('page',$get)));
			
			$limit=50;
			$offset=($limit*$page);
			
			if($poli){
			$ww="id_ms_poliklinik IN ($poli)";
			$this->db->where($ww);
			}
			$this->db->select('
			ms_tindakan.id,
			ms_tindakan.nama,
			ms_tindakan.biaya,
			ms_kategori_tindakan.nama as kategori_tindakan
			');
			$this->db->group_start(); 
			$this->db->like('ms_tindakan.nama', $search,'both');
			$this->db->or_like('ms_kategori_tindakan.nama', $search,'both');
			$this->db->group_end();
			
			if($limit){
				$this->db->limit($limit, $offset);
			}
			$this->db->join('ms_kategori_tindakan','ms_kategori_tindakan.id = ms_tindakan.id_kategori_tindakan','inner');
			$data = $this->db->get('ms_tindakan')->result();
			$found=count($data);
			
			if($found > 0){
				foreach ($data as $key => $value) {
					$data[] = array(
					'id' => $value->id,
					'text' => $value->nama.' ('.$value->kategori_tindakan.') - '.rupiah($value->biaya)
					);
				}
				} else {
				$data[] = array(
				'id' => '',
				'text' => 'Data tidak ditemukan.'
				);
			}
			
			$this->db->select('
			COUNT(ms_tindakan.id) as total_row
			',false);	
			$total_row = $this->db->get('ms_tindakan')->row();
			
			$result['total_count'] = $total_row->total_row;
			$result['items'] = $data;
			// return the result in json
			echo json_encode($result);
		}
		
		
		public function json_ms_poliklinik()
		{
			$get = $this->input->get(NULL,TRUE);
			$search = strip_tags(trim(element('q',$get)));
			$page = strip_tags(trim(element('page',$get)));
			
			
			$data = $this->db->get('ms_poliklinik')->result();
			$found=count($data);
			
			if($found > 0){
				foreach ($data as $key => $value) {
					$data[] = array(
					'id' => $value->id,
					'text' => $value->nama
					);
				}
				} else {
				$data[] = array(
				'id' => '',
				'text' => 'Data tidak ditemukan.'
				);
			}
			
			$this->db->select('
			COUNT(ms_poliklinik.id) as total_row
			',false);	
			$total_row = $this->db->get('ms_poliklinik')->row();
			
			$result['total_count'] = $total_row->total_row;
			$result['items'] = $data;
			// return the result in json
			echo json_encode($result);
		}
		
		public function json_ms_penunjang()
		{
			$get = $this->input->get(NULL,TRUE);
			$search = strip_tags(trim(element('q',$get)));
			$page = strip_tags(trim(element('page',$get)));
			
			$this->db->group_start();
				$this->db->like('nama',$search,'both');
			$this->db->group_end();
			$data = $this->db->get('ms_penunjang')->result();
			$found=count($data);
			
			if($found > 0){
				foreach ($data as $key => $value) {
					$data[] = array(
					'id' => $value->id,
					'text' => $value->nama
					);
				}
				} else {
				$data[] = array(
				'id' => '',
				'text' => 'Data tidak ditemukan.'
				);
			}
			
			$this->db->group_start();
				$this->db->like('nama',$search,'both');
			$this->db->group_end();
			$this->db->select('
			COUNT(ms_penunjang.id) as total_row
			',false);	
			$total_row = $this->db->get('ms_penunjang')->row();
			
			$result['total_count'] = $total_row->total_row;
			$result['items'] = $data;
			// return the result in json
			echo json_encode($result);
		}
		
		public function save_poliklinik_pasien(){
			$post = $this->input->post(NULL,TRUE);
			
			if($this->_save_poliklinik_pasien($post))
			{
				$response = array(
					'status' => true,
					'message' => 'Internal Konsulasi telah selesai di proses !',
					'redirect' => site_url('konsultasi')
				);
				echo json_encode($response);
			}
		}
		

		function modal_penunjang(){
			$post = $this->input->post(NULL,TRUE);
			$PenunjangID=element('IDPenunjang',$post);
			$data["PenunjangID"]=element('IDPenunjang',$post);
			$data["listkategori"]=explode(",",element('listkategori',$post));
			$data["last_id"]=element('last_id',$post);
			$data["kelompok"]=$this->db->query("SELECT kelompok FROM ms_kategori_penunjang WHERE id_ms_penunjang='$PenunjangID' GROUP BY kelompok")->result();
			$this->load->view("modal_penunjang",$data);
		}
		
		private function _save_poliklinik_pasien($post){
			
			$this->db->trans_start();
			$idbillbef= element('id_billing_before',$post);
			$insert['id_pasien'] = element('id_pasien',$post);
			$insert['id_jenis_appointment'] = element('id_jenis_appointment',$post);
			$insert['id_appointment_before'] = element('id_appointment_before',$post);
			$insert['id_poliklinik'] = element('id_poliklinik',$post);
			$insert['id_cara_bayar'] = element('id_cara_bayar',$post);
			$insert['id_bpjs_type'] = element('id_bpjs_type',$post);
			$insert['no_bpjs'] = element('no_bpjs',$post);
			$insert['no_polis'] = element('no_bpjs',$post);
			$insert['nama_perusahaan'] = element('nama_perusahaan',$post);
			$insert = array_filter($insert);
			
			$this->db->insert('trs_appointment',$insert);
			$id_appointment = $this->db->insert_id();
			$this->db->where('id',element('id_pasien',$post))->update('ms_pasien',array('arrived_at'=>date('Y-m-d H:i:s')));
			if( $this->db->affected_rows() > 0 )
			{
				$no_tagihan = $this->Billing_model->no_tagihan();
				
				$komponen = $this->db->select('ms_komponen_registrasi.*')
				->get_where('ms_komponen_registrasi',array('id'=>element('id_komponen',$post)))->row_array();
			
				if($insert['id_cara_bayar'] == 2){
					
					if(count($komponen))
					{
						$insert_tagihan['no_tagihan'] = $no_tagihan;
						$insert_tagihan['id_appointment'] = $id_appointment;
						$insert_tagihan['id_komponen'] = $komponen['id'];
						$insert_tagihan['nominal'] = $komponen['nominal'];
						$insert_tagihan['total_bayar'] = $komponen['nominal'];
						$insert_tagihan['`status`'] = '1';
						$this->db->insert('trs_billing',$insert_tagihan);
						
						$anamesa['id_appointment'] = $id_appointment;
						$this->db->insert('trs_anamesa',$anamesa);
						$idd=$this->db->insert_id();
			
						$data_konsultasi['id_anamesa'] = $idd;
						$this->db->insert('trs_konsultasi',$data_konsultasi);
						
						$this->db->query("UPDATE trs_billing SET pindah_poli='ya' WHERE id='".$idbillbef."'");
					}
				}
				else{
					if(count($komponen))
					{
						$insert_tagihan['no_tagihan'] = $no_tagihan;
						$insert_tagihan['id_appointment'] = $id_appointment;
						$insert_tagihan['id_komponen'] = $komponen['id'];
						$insert_tagihan['nominal'] = $komponen['nominal'];
						$this->db->insert('trs_billing',$insert_tagihan);

						$this->db->query("UPDATE trs_billing SET pindah_poli='ya' WHERE id='".$idbillbef."'");
						
						// $anamesa['id_appointment'] = $id_appointment;
						// $this->db->insert('trs_anamesa',$anamesa);
						// $idd=$this->db->insert_id();
			
						// $data_konsultasi['id_anamesa'] = $idd;
						// $this->db->insert('trs_konsultasi',$data_konsultasi);
					}	
				}
				
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
	}
?>
