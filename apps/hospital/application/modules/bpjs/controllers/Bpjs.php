<?php
/**
	* CodeIgniter Core Model
	*
	* @package         CodeIgniter
	* @subpackage      Controller
	* @category        Pasien Controller
	* @author          Amir Mufid
	* @version         1.1
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Bpjs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->model('Pasien_model');
		$this->load->model('billing/Billing_model');
		$config['table'] = 'ms_rawat_inap';
		$config['column_order'] = array(null,null,'rm','nama_lengkap','no_identitas','jk','usia','hp','alamat','add_time','last_update','last_user',null);
		$config['column_search'] = array('rm','nama_lengkap','usia','alamat','ruang_rawat','tgl_keluar','add_time','last_update','last_user');
		$config['order'] = array('last_update' => 'DESC');
		$this->Pasien_model->initialize($config);
    }

    public function index()
    {

		$data['title'] = 'Pendaftaran';
		$data['id_table'] = 'trs_rawat_inap';
		$data['link_save'] = 'rawat_inap/save_ri/';
		
		$this->display('form_pasien_ri',$data);
    }
    public function cari()
    {
		$post=$this->input->post(NULL,TRUE);
		$head=header_bpjs();
		
		$domain=ws_url();
		$link=url_bpjs("peserta_kartu");
		$full_url=$domain.$link->link.element('key',$post);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $full_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json=curl_exec($ch);
		curl_close ($ch);
		$result=json_decode($json);
		if($result){
		if($result->metadata->code == 200){
					$link=url_bpjs("rujukan_peserta");
					$full_url=$domain.$link->link.$result->response->peserta->noKartu;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $full_url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$json=curl_exec($ch);
					curl_close ($ch);
					$rujuk=json_decode($json);
			
					if($rujuk->metadata->code == 200){
						$data['rujukan']=$rujuk;
					}else{
						$data['rujukan']=array();
					}
			echo '<div class="alert alert-info col-md-2">
  <strong>'.$rujuk->metadata->code.'</strong> '.$rujuk->metadata->message.'
</div>';
			$data['json']=$result;
			$data['poli']=$this->db->query("SELECT * FROM ms_poliklinik WHERE code != ''")->result_array();
			$this->load->view("pendaftaran",$data);
		}else{
			echo "<center><h2>Permintaan Gagal!</h2><label class='label label-info' style='font-size:16px;'><b>".$result->metadata->message."</b></label></center>";
		}
		}else{
			
			echo "<center><h2>Permintaan Gagal!</h2><label class='label label-info' style='font-size:16px;'><b>Jaringan lambat, silahkan coba kembali.</b></label></center>";
		}
    }
		
	public function save(){
		$post = $this->input->post(NULL,TRUE);
		
		$cekrm=$this->db->query("SELECT * FROM ms_pasien WHERE no_identitas='".element('no_identitas',$post)."' OR (nama_lengkap = '".element('no_identitas',$post)."' OR tanggal_lahir='".element('tanggal_lahir',$post)."')")->row_array();
		
		$auto_rm = $this->db->query("SELECT ifnull((MAX(rm)+1),1) as auto_rm FROM ms_pasien")->row_array();
		
		$rm							= (!empty($cekrm['id']))?$cekrm['id']:element('auto_rm',$auto_rm);
		/* DISINI BUAT MASUKIN DATA PASIEN KE SERVER RS */
		$pasien['rm']				= str_pad($rm, 6, "0", STR_PAD_LEFT); 
		$pasien['nama_lengkap']		= element('nama_lengkap',$post);
		$pasien['tipe_identitas']	= "KTP";
		$pasien['no_identitas']		= element('no_identitas',$post);
		$pasien['jk']				= element('jk',$post);
		$pasien['tanggal_lahir'] 	= element('tanggal_lahir',$post);
		$pasien['no_rujukan']		= element('noRujukan',$post);
		$pasien['rujukan_dari']		= element('ppkRujukan',$post);
		$pasien['ppkPelayanan']		= element('ppkPelayanan',$post);
		$pasien['nokartubpjs']		= element('no_kartu',$post);
		/* SAMPAI SINI */
		
		$poli=explode('_',element('poliTujuan',$post));
		
		// INI BUAT INSERT SEP 
			$head=header_bpjs(); //FUNGSI BUAT AMBIL HEADER ADA DI get_field helper di core

			
			$domain=ws_url(); 	// FUNGSI BUAT SETTING DOMAIN WS BPJS ADA DI CONFIG.PHP
			$link=url_bpjs("insert_sep"); //FUNGSI BUAT AMBIL URL KATALOG ADA DI get_field helper di core
			$full_url=$domain.$link->link;
			
			$bpjs["request"]["t_sep"]["noKartu"]=element('no_kartu',$post);
            $bpjs["request"]["t_sep"]["tglSep"]=date("Y-m-d h:i:s");
            $bpjs["request"]["t_sep"]["tglRujukan"]=convert_tgl(element('tglRujukan',$post),"Y-m-d h:i:s");
			$bpjs["request"]["t_sep"]["noRujukan"]=element('noRujukan',$post);
			$bpjs["request"]["t_sep"]["ppkRujukan"]=element('ppkRujukan',$post);
			$bpjs["request"]["t_sep"]["ppkPelayanan"]=element('ppkPelayanan',$post);
			$bpjs["request"]["t_sep"]["jnsPelayanan"]=element('jnsPelayanan',$post);
			$bpjs["request"]["t_sep"]["catatan"]=element('catatan',$post);
			$bpjs["request"]["t_sep"]["diagAwal"]=element('diagAwal',$post);
			$bpjs["request"]["t_sep"]["poliTujuan"]=$poli[1];
			$bpjs["request"]["t_sep"]["klsRawat"]=element('klsRawat',$post);
			$bpjs["request"]["t_sep"]["lakaLantas"]=element('lakaLantas',$post);
			$bpjs["request"]["t_sep"]["lokasiLaka"]=element('lokasiLaka',$post);
			$bpjs["request"]["t_sep"]["user"]="RS";
			$bpjs["request"]["t_sep"]["noMr"]=$pasien['rm'];
			$data_json = json_encode($bpjs);
			
			$head[]='Content-Type: application/x-www-form-urlencoded';
			$head[]='Content-Length: ' . strlen($data_json);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $full_url);                                              
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$json=curl_exec($ch);
			curl_close ($ch);
			$result=json_decode($json);
			if($result){
			$hasil=$result->metadata->code;
			$response=$result->response;
		/* SAMPAI SINI
		$result=true;
		if($result){
			$hasil=200;
			$response=9999; */
		//debug doang
		
		
		if($hasil == 200){
			
		$pasien['no_sep']	= $response;
		$poliklinik=array();
		$poliklinik['id_bpjs_type']=element('no_kartu',$post);
		$pasien = array_string_to_null($pasien);
		
		if(empty($cekrm['id']))
		{
			if($this->db->insert('ms_pasien',$pasien))
			{
				$success_pasien = 1;
				$id_pasien = $this->db->insert_id();
			}
		}
		else
		{
			if($this->db->where('id',$cekrm['id'])->update('ms_pasien',$pasien))
			{
				$success_pasien = 1;
				$id_pasien = $cekrm['id'];
			}
		}
		
		
		
		$this->db->trans_start();
		$p=element('jnsPelayanan',$post);
		if($p == 1){
		$auto_rawat = $this->db->query("SELECT ifnull((MAX(no_rawat)+1),1) as auto_rm FROM `trs_rawat_inap`")->row_array();
		
		$rm								= element('auto_rm',$auto_rawat);
		$ins['no_rawat']				= str_pad($rm, 8, "0", STR_PAD_LEFT); 
		$ins['id_kamar']				= element("id_kamar",$post);
		$ins['id_ruang']				= element("id_ruang",$post);
		$ins['no_rujukan']			= element('noRujukan',$post);
		$ins['rujukan_dari']			= element('ppkRujukan',$post);
		$ins['id_pasien'] 			= $id_pasien;
		$ins['id_cara_bayar'] 		= 2;
		$ins['id_bpjs_type'] 		= 6;
		$ins['no_bpjs'] 				= element('no_kartu',$post);
		$ins = array_filter($ins);
			
			$this->db->insert('trs_rawat_inap'.$p,$ins);
		}
			$insert['id_pasien'] = $id_pasien;
			if($poli[0] == 20 OR $poli[0] == 28){
				$insert['id_jenis_appointment'] =2;
				$p=2;
				$id_komponen=2;
			}
			else{
				if(element('jnsPelayanan',$post) == 1){
					$insert['id_jenis_appointment'] =3;
					$p=3;
					$id_komponen=1;
				}
				else{
					$insert['id_jenis_appointment'] =1;
					$p=1;
					$id_komponen=1;
				}
			}
			$insert['id_poliklinik'] = $poli[0];
			$insert['id_cara_bayar'] = 2;
			$insert['id_bpjs_type'] = 6;
			$insert['no_bpjs'] = element('no_kartu',$post);
			$insert = array_filter($insert);

			$this->db->insert('trs_appointment',$insert);
			$id_appointment = $this->db->insert_id();
			
			$up['id_pasien']=$id_pasien;
			$up['no_sep']=$response;
			$up['ppkPelayanan']=element('ppkPelayanan',$post);
			$this->db->insert("riwayat_sep",$up);
			
			$this->db->where('id',$id_pasien)->update('ms_pasien',array('arrived_at'=>date('Y-m-d H:i:s')));
			if( $this->db->affected_rows() > 0 )
			{
				$no_tagihan = $this->Billing_model->no_tagihan();
				
				$komponen = $this->db->select('ms_komponen_registrasi.*')
				->get_where('ms_komponen_registrasi',array('id'=>$id_komponen))->row_array();
				
					$insert_tagihan['no_tagihan'] = $no_tagihan;
					$insert_tagihan['id_appointment'] = $id_appointment;
					$insert_tagihan['id_komponen'] = $id_komponen;
					$insert_tagihan['nominal'] = get_field($id_komponen,'ms_komponen_registrasi','nominal');
					$insert_tagihan['total_bayar'] = $insert_tagihan['nominal'];
					$insert_tagihan['`status`'] = '1';
					
					$this->db->insert('trs_billing',$insert_tagihan);
					
					$anamesa['id_appointment'] = $id_appointment;
					$this->db->insert('trs_anamesa',$anamesa);
					$idd=$this->db->insert_id();
			
					$data_konsultasi['id_anamesa'] = $idd;
					$this->db->insert('trs_konsultasi',$data_konsultasi);
			
			$this->db->trans_complete();
					$response = array(
						'status' => true,
						'message' => 'Pasien baru dengan :<br>RM : '.$pasien['rm'].' <br> Nama : '.element('nama_lengkap',$post).' <br>telah berhasil di tambahkan',
						'redirect' => site_url('pasien').'?p='.$p
					);
					die(json_encode($response));
			}
					

		}
		else{
					$response = array(
						'status' => false,
						'message' => 'NO SEP gagal di proses, transaksi tidak berhasil.<br>Kode Kesalahan : '.$hasil.' - '.$result->metadata->message
					);
					die(json_encode($response));
		}
			}else{
				$response = array(
						'status' => false,
						'message' => 'Koneksi lambat silahkan coba kembali.'
					);
					die(json_encode($response));
			}
	}
			
		function get_provider(){
			$search = ($_GET['q'])?strip_tags(trim($_GET['q'])):'';
			$head=header_bpjs();
		
		$domain=ws_url();
		$link=url_bpjs("provider");
		$full_url=$domain.$link->link."query?nama=$search&start=0&limit=100";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $full_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json=curl_exec($ch);
		curl_close ($ch);
		$res=json_decode($json);
		
			if($res)
			{
					foreach($res->response->list as $r){
						$p['id']=$r->kdProvider;
						$p['text']=$r->kdProvider." - ".$r->nmProvider." - ".$r->nmCabang;
						$p['nama']=$r->nmProvider;
						$data[]=$p;
					}
			} 			
			else 
			{
				$data[] = array(
					'id' => '',
					'text' => 'Data tidak ditemukan.',
					'nama' => 'Data tidak ditemukan.',
				);
			
			}
			
			$result['items'] = $data;
			// return the result in json
			echo json_encode($result); 
		}
		

	
}
?>
