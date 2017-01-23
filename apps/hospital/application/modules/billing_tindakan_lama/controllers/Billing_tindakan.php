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
	
	class Billing_tindakan extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('Konsultasi_model');
			$this->load->model('Billing_model');
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
			$data['title'] = 'Billing Tindakan';
			$data['id_table'] = 'billing_tindakan';
			$data['datatable_list'] = 'billing_tindakan/ajax_list';
			$data['datatable_edit'] = 'billing_tindakan/ajax_edit';
			$data['datatable_delete'] = 'billing_tindakan/ajax_delete';
			$data['datatable_save'] = 'billing_tindakan/ajax_save';
			$this->template->display('billing_tindakan',$data);
		}
		    public function bill()
    {
		$data['title'] = 'Billing';
		$data['id_table'] = 'billing_tbl';
		$data['datatable_list'] = 'billing_tindakan/ajax_list_2/';
		$data['datatable_edit'] = 'billing_tindakan/ajax_edit';
		$data['datatable_delete'] = 'billing_tindakan/ajax_delete';
		$data['datatable_save'] = 'billing_tindakan/ajax_save';
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
			
			$diagnosa = $diagnosa = $this->db->select('
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

   public function ajax_list_2()
	{	
		$id='1,2';
		$list = $this->Billing_model->get_datatables($id);
		
		$data = array();
		$no = $_POST['start'];
		$total = 0;
		foreach ($list as $row) {
			$no++;
			$fields = array();
			$fields[] = $no;
			
			$fields[] = $row->rm;
			$fields[] = $row->nama_lengkap;
			$fields[] = $row->cara_bayar;
			$fields[] = $row->poliklinik;
			$fields[] = $row->komponen;
			$fields[] = rupiah($row->nominal);
			$fields[] = convert_tgl($row->add_time,'d M Y H:i',1);
			$fields[] = ($row->status == 1)?'<i class="label label-success">Sudah Bayar</i>':'<i class="label label-danger">Belum Bayar</i>';
			$w=($row->pindah_poli == 'ya')?'':' <button onclick="modal_poli('.$row->id.')" type="button" class="btn btn-default" rel="tooltip" title="Daftar ke Poliklinik"><img src="'.FILES_HOST.'img/panah.png"></button>';
			$fields[] = ($row->status == 1)?
				'<a href="'.site_url('billing/kwitansi/'.$row->id_pasien.'/'.$row->id).'" target="_BLANK" class="btn btn-default " rel="tooltip" title="Cetak Kwitansi"><i class="fa fa-print"></i></a>'.$w.' <button type="button" onclick="modal_pembatalan('.$row->id.')" type="button" class="btn btn-danger" rel="tooltip" title="Batalkan"><i class="fa fa-times"></i></button>'
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
	
		
		public function ajax_list()
		{	
			$list = $this->Konsultasi_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $row) {
				$cek=$this->db->query("SELECT id,`status` FROM trs_billing WHERE id_appointment='$row->id_appointment' AND id_komponen='4'")->row();
				if(!empty($cek->id)){
					$label=($cek->status == '1')?'<i class="label label-success">Sudah Bayar</i>':'<i class="label label-danger">Belum Bayar</i>';
					$action=($cek->status == '1')?'<button type="button" onclick="window.open(\' '.site_url('billing_konsultasi/kwitansi/'.$row->id_pasien.'/'.$cek->id).' \')" target="_BLANK" class="btn btn-default"  title="Ubah data"><i class="fa fa-print"></i> Kwitansi</button>':'<button type="button" onclick="addmodal2('.$row->id.','.$cek->id.')" class="btn btn-default"> <i class="flaticon-clinic-history-medical-paper-on-clipboard"></i> Tindakan</button>';
				}else{
					$label='<i class="label label-warning">-</label>';
					$action='<button type="button" onclick="addmodal('.$row->id.')" class="btn btn-default"> <i class="flaticon-clinic-history-medical-paper-on-clipboard"></i> Tindakan</button>';
				}
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
				$fields[] = $label;
				$fields[] = $action;
				
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
 trs_appointment.id_pasien = '$PasienID' AND trs_konsultasi.id !='$KonsultasiID' GROUP BY id_anamesa
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
			echo "
		<tr>
			<td>$n</td>
			<td>$r->nama</td>
			<td style='text-align:center'>$r->add_time</td>
			<td style='text-align:center'><button onclick='load_mr($r->id)' class='btn btn-info' type='button'>Lihat Riwayat</button></td>
		</tr>";
			$n++; }
echo "</table></div>";
echo '<center><button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button></center>';
		}
		public function form_konsultasi2($id,$id_billing="")
		{
			$data['id_billing']=$id_billing;
			$data['ket'] = "";
			$data['title'] = 'Konsultasi';
			$data['id_table'] = 'konsultasi';
			$data['datatable_save'] = 'billing_tindakan/ajax_save';
			
			$data['cara_bayar'] = $this->db->select('id,nama')->get('ms_cara_bayar')->result_array();
			
			$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="id_poliklinik IN ($otoritas)";
			$this->db->where($ww);
			}
			$data['poliklinik2'] = $this->db->get('ms_penunjang')->result_array();
			$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
			$data['jenis_appointment'] = $this->db->get('ms_jenis_appointment')->result_array();
			$data['bpjs_type'] = $this->db->get('ms_bpjs_type')->result_array();
			$data['ruang'] = $this->db->get('ms_ruang')->result_array();
			$data['kelas'] = $this->db->group_by('kelas')->get('ms_kamar')->result_array();
			
			
			$data['konsultasi'] = $konsultasi = $this->db->select('
			trs_konsultasi.id,
			trs_konsultasi.id as rowid,
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

			$this->load->view('form_konsultasi_edit',$data);
		}
		
		public function form_konsultasi($id,$ket="")
		{
			$data['ket'] = $ket;
			$data['title'] = 'Konsultasi';
			$data['id_table'] = 'konsultasi';
			$data['id_table2'] = 'penunjang';
			$data['datatable_save'] = 'billing_tindakan/ajax_save';
			
			$data['cara_bayar'] = $this->db->select('id,nama')->get('ms_cara_bayar')->result_array();
			
			$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="id_poliklinik IN ($otoritas)";
			$this->db->where($ww);
			}
			$data['poliklinik2'] = $this->db->get('ms_penunjang')->result_array();
			$data['poliklinik'] = $this->db->get('ms_poliklinik')->result_array();
			$data['jenis_appointment'] = $this->db->get('ms_jenis_appointment')->result_array();
			$data['bpjs_type'] = $this->db->get('ms_bpjs_type')->result_array();
			$data['ruang'] = $this->db->get('ms_ruang')->result_array();
			$data['kelas'] = $this->db->group_by('kelas')->get('ms_kamar')->result_array();
			
			
			$data['konsultasi'] = $konsultasi = $this->db->select('
			trs_konsultasi.id,
			trs_konsultasi.id as rowid,
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
			$this->load->view('form_konsultasi',$data);
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
			$edit='no';
			$post = $this->input->post(NULL,TRUE);
			$total=element('total',$post);
			$edit=(element('edit',$post) == 'ya')?'ya':'no';
			$id_konsultasi=element('id',$post);
			if(!empty($post['tindakan']))
			{
				$value = $post['tindakan'];
				foreach($value['id'] as $index=>$val)
				{
					if($value['biaya'][$index] > 0){
					$tindakan['id'] = $value['id'][$index];
					$tindakan['id_ms_tindakan'] = $value['id_ms_tindakan'][$index];
					$tindakan['jumlah_tindakan'] = $value['jumlah'][$index];
					$tindakan['id_konsultasi'] = element('id',$post);
					$tindakan['biaya'] = $value['biaya'][$index];
					$tindakan['keterangan'] = $value['keterangan'][$index];
					$tindakan_batch[] = $tindakan;
					}
				}
				
				$this->db->replace_batch('trs_tindakan',$tindakan_batch);		
			}
			
			$pasien = $this->db->select('id_pasien')
			->join('trs_anamesa','trs_anamesa.id = trs_konsultasi.id_anamesa')
			->join('trs_appointment','trs_anamesa.id_appointment = trs_appointment.id')
			->where('trs_konsultasi.id',$id_konsultasi)
			->get('trs_konsultasi')->row_array();
			
			if(!empty($post['penunjang']))
			{
				$value = $post['penunjang'];
				foreach($value['id_ms_penunjang'] as $index=>$val)
				{
					if($value['biaya'][$index] != ''){
					$penunjang['id_ms_penunjang'] = $value['id_ms_penunjang'][$index];
					$penunjang['biaya'] = rupiah_to_number($value['biaya'][$index]);
					$penunjang['id_konsultasi'] = element('id',$post);
					$penunjang['id_pasien'] = $pasien['id_pasien'];
					$penunjang['id_dokter'] = '';
					$penunjang['jumlah'] = 1;
					$penunjang['keterangan'] = $value['keterangan'][$index];
					
					$penunjang_batch[] = $penunjang;
					}
				}
				
				$this->db->replace_batch('trs_penunjang',$penunjang_batch);		
			}
	
				$cekid=$this->db->query("SELECT	trs_anamesa.id_appointment FROM trs_konsultasi INNER JOIN trs_anamesa ON trs_konsultasi.id_anamesa = trs_anamesa.id	WHERE trs_konsultasi.id='$id_konsultasi' LIMIT 1")->row();	
				
				if($total > 0  OR $total != "" OR $total != NULL){				
				$no_tagihan = $this->db->select('CONCAT(YEAR(NOW()),LPAD(ifnull(max(RIGHT(no_tagihan,5))+1,1),5,0)) as max_no_tagihan',false)
				->where('left(no_tagihan,4) = YEAR(NOW())',null,false)
				->get('trs_billing')->row();
				
				$i['id_appointment']=$cekid->id_appointment;
				$i['id_komponen']=4;
				$i['id_jenis_bayar']=1;
				$i['nominal']=$total;
				$i['total_bayar']=$total;
				$i['status']='1';
				if($edit == 'no'){
				$i['no_tagihan']=$no_tagihan->max_no_tagihan;
					if($this->db->insert("trs_billing",$i)){
						$idb=$this->db->insert_id();
						
						$this->db->where('id',$idb);
						$this->db->update("trs_billing",$i);
					}
				}else{
				$this->db->where('id',element('id_billing',$post));
				$this->db->update("trs_billing",$i);
				}
				}
			

			$response = array(
			'status' => true,
			'message' => 'Konsulasi telah selesai di proses !',
			'redirect' => site_url('billing_tindakan')
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
			$post = $this->input->post(NULL,TRUE);
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
			$query['usia_thn'] = $post['usia_thn'];
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
		
		public function json_tindakan()
		{
			$get = $this->input->get(NULL,TRUE);
			$search = strip_tags(trim(element('q',$get)));
			$page = strip_tags(trim(element('page',$get)));
			
			$limit=50;
			$offset=($limit*$page);
			
			$otoritas=$this->session->userdata('id_pol');
			if($otoritas){
			$ww="id_ms_poliklinik IN ($otoritas)";
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
				echo json_encode(array("status" => TRUE));
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
			
			$insert['id_pasien'] = element('id_pasien',$post);
			$insert['id_jenis_appointment'] = element('id_jenis_appointment',$post);
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
				
				if(count($komponen))
				{
					$insert_tagihan['no_tagihan'] = $no_tagihan;
					$insert_tagihan['id_appointment'] = $id_appointment;
					$insert_tagihan['id_komponen'] = $komponen['id'];
					$insert_tagihan['nominal'] = $komponen['nominal'];
					$this->db->insert('trs_billing',$insert_tagihan);
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
