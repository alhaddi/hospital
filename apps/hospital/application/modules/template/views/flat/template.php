<!doctype html>
<html>
<head>
	<?=$head?>
	<?=$libs?>	
</head>

<body data-layout-sidebar="fixed" data-layout-topbar="fixed" style="background-color:#000;" class="theme-darkblue" data-theme="theme-darkblue">
	
	
	
	<div id="navigation">
		<div class="container-fluid">
			<?=$header?>
		</div>
	</div>
	<div class="container-fluid" id="content">
		<div id="left" class="ui-sortable ui-resizable forced-hide" style="display: none;">
			<form action="http://www.eakroko.de/flat/search-results.html" method="GET" class='search-form'>
				<div class="search-pane">
					<input type="text" name="search" placeholder="Search here...">
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</form>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Content</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li class='dropdown'>
						<a href="#" data-toggle="dropdown">Articles</a>
						<ul class="dropdown-menu">
							<li>
								<a href="#">Action #1</a>
							</li>
							<li>
								<a href="#">Antoher Link</a>
							</li>
							<li class='dropdown-submenu'>
								<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Go to level 3</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">This is level 3</a>
									</li>
									<li>
										<a href="#">Unlimited levels</a>
									</li>
									<li>
										<a href="#">Easy to use</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">News</a>
					</li>
					<li>
						<a href="#">Pages</a>
					</li>
					<li>
						<a href="#">Comments</a>
					</li>
				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Plugins</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="#">Cache manager</a>
					</li>
					<li class='dropdown'>
						<a href="#" data-toggle="dropdown">Import manager</a>
						<ul class="dropdown-menu">
							<li>
								<a href="#">Action #1</a>
							</li>
							<li>
								<a href="#">Antoher Link</a>
							</li>
							<li class='dropdown-submenu'>
								<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Go to level 3</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">This is level 3</a>
									</li>
									<li>
										<a href="#">Unlimited levels</a>
									</li>
									<li>
										<a href="#">Easy to use</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Contact form generator</a>
					</li>
					<li>
						<a href="#">SEO optimization</a>
					</li>
				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Settings</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="#">Theme settings</a>
					</li>
					<li class='dropdown'>
						<a href="#" data-toggle="dropdown">Page settings</a>
						<ul class="dropdown-menu">
							<li>
								<a href="#">Action #1</a>
							</li>
							<li>
								<a href="#">Antoher Link</a>
							</li>
							<li class='dropdown-submenu'>
								<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Go to level 3</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">This is level 3</a>
									</li>
									<li>
										<a href="#">Unlimited levels</a>
									</li>
									<li>
										<a href="#">Easy to use</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Security settings</a>
					</li>
				</ul>
			</div>
			<div class="subnav subnav-hidden">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-right"></i>
						<span>Default hidden</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="#">Menu</a>
					</li>
					<li class='dropdown'>
						<a href="#" data-toggle="dropdown">With submenu</a>
						<ul class="dropdown-menu">
							<li>
								<a href="#">Action #1</a>
							</li>
							<li>
								<a href="#">Antoher Link</a>
							</li>
							<li class='dropdown-submenu'>
								<a href="#" data-toggle="dropdown" class='dropdown-toggle'>More stuff</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">This is level 3</a>
									</li>
									<li>
										<a href="#">Easy to use</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Security settings</a>
					</li>
				</ul>
			</div>
		</div>
		<div id="main" style="margin-left: 0px; min-height:108%; <?=($this->session->userdata("username") == "bendahara")?"
		background-image: url('".FILES_HOST."img/bg_dashboard.png');
		background-repeat: repeat-x;
		":""?>" >
		 <?=($this->session->userdata("username") == "bendahara")?"<div style='background-color: rgba(54,142,224,0.12);  min-height:580px; '>":""?>
			<?=$content?>
		<?=($this->session->userdata("username") == "bendahara")?"</div>":""?>
		<div id="modal" class="modal fade in" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">Modal title</h4>
					</div>
					<!-- /.modal-header -->
					<div class="modal-body">
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas, laudantium, inventore, impedit, excepturi odio quia aut sapiente delectus velit quaerat nesciunt ipsa laboriosam quam placeat ad atque hic vel quibusdam nisi reprehenderit numquam voluptatum
							consectetur modi sint saepe totam tenetur necessitatibus minima provident cumque rem aliquid cupiditate libero omnis tempora.
						</p>
					</div>
					<!-- /.modal-body -->
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
					<!-- /.modal-footer -->
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		
		</div>
		<div id="footer">
			<?=$footer?>
			<a href="#" class="gototop">
				<i class="fa fa-arrow-up"></i>
			</a>
		</div>
		
		<div id="modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas, laudantium, inventore, impedit, excepturi odio quia aut sapiente delectus velit quaerat nesciunt ipsa laboriosam quam placeat ad atque hic vel quibusdam nisi reprehenderit numquam voluptatum
						consectetur modi sint saepe totam tenetur necessitatibus minima provident cumque rem aliquid cupiditate libero omnis tempora.
					</p>
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
				<!-- /.modal-footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	</div>
</body>
</html>
