<li class="">
	<a href="<?=site_url('dashboard')?>">
		<i class="fa fa-dashboard fa-fw"></i> <span>Dashboard</span> 
	</a>
</li>
<?php	
	$this->db->select('
		sys_menu.id,
		sys_menu.nama,
		sys_menu.link,
		sys_menu.icon,
		sys_menu.parent_id
	');
	$this->db->where('sys_akses_menu.akses','READ');
	$this->db->where('sys_akses_menu.username',$this->session->userdata('username'));
	$this->db->join('sys_akses_menu','sys_akses_menu.id_menu = sys_menu.id','inner');
	$this->db->order_by('sys_menu.urut','asc');
	$this->db->order_by('sys_menu.parent_id','asc');
	$data_menu = $this->db->get('sys_menu')->result();

foreach($data_menu as $row){
	$data[$row->parent_id][] = $row;
}
if(!empty($data)){
echo load_menu($data);
}
?>