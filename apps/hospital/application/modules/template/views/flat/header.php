<?php
	$identitas = $this->db->get('ms_identitas')->row_array();	
	$sess = $this->session;
?>
<style>
#navigation #brand {
    margin-top: 4px;
    padding-right: 28px
    margin-bottom: 4px;
}
</style>
<a href="<?=site_url()?>" id="brand"><img style="width:60px;" src="<?=FILES_HOST?>/img/<?=$identitas['logo'].'_header.png'?>"></a>
<!--a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation">
	<i class="fa fa-bars"></i>
</a-->
<ul class='main-nav'>
	<?=$list_menu?>
</ul>
<div class="user">
	<ul class="icon-nav">
		
		
		<li class="dropdown sett">
			<a href="#" class='dropdown-toggle' data-toggle="dropdown">
				<i class="fa fa-cog"></i>
			</a>
			<ul class="dropdown-menu pull-right theme-settings">
				<li>
					<span>Layout-width</span>
					<div class="version-toggle">
						<a href="#" class='set-fixed'>Fixed</a>
						<a href="#" class="active set-fluid">Fluid</a>
					</div>
				</li>
				<li>
					<span>Topbar</span>
					<div class="topbar-toggle">
						<a href="#" class='set-topbar-fixed'>Fixed</a>
						<a href="#" class="active set-topbar-default">Default</a>
					</div>
				</li>
				<li>
					<span>Sidebar</span>
					<div class="sidebar-toggle">
						<a href="#" class='set-sidebar-fixed'>Fixed</a>
						<a href="#" class="active set-sidebar-default">Default</a>
					</div>
				</li>
			</ul>
		</li>
		<li class='dropdown colo'>
			<a href="#" class='dropdown-toggle' data-toggle="dropdown">
				<i class="fa fa-tint"></i>
			</a>
			<ul class="dropdown-menu pull-right theme-colors">
				<li class="subtitle">
					Predefined colors
				</li>
				<li>
					<span class='red'></span>
					<span class='orange'></span>
					<span class='green'></span>
					<span class="brown"></span>
					<span class="blue"></span>
					<span class='lime'></span>
					<span class="teal"></span>
					<span class="purple"></span>
					<span class="pink"></span>
					<span class="magenta"></span>
					<span class="grey"></span>
					<span class="darkblue"></span>
					<span class="lightred"></span>
					<span class="lightgrey"></span>
					<span class="satblue"></span>
					<span class="satgreen"></span>
				</li>
			</ul>
		</li>
		
	</ul>
	<div class="dropdown">
		<a href="#" class='dropdown-toggle' data-toggle="dropdown"><?=$this->session->userdata('nama')?>
			<?=get_img('user/'.$sess->userdata('kode_user').'/foto/'.$sess->userdata('foto'),'avatar','0','','max-height:27px;max-width:27px;')?>
		</a>
		<ul class="dropdown-menu pull-right">
			<li>
				<a href="<?=site_url('hrm/profile')?>">Edit profile</a>
			</li>
			<li>
				<a href="<?=site_url('identitas')?>">Account settings</a>
			</li>
			<li>
				<a href="<?=site_url('login/logout')?>">Sign out</a>
			</li>
		</ul>
	</div>
</div>