/* 
	** Developed by Amir Mufid **
*/

/*Modal PopUp*/

var base_url = window.location.origin;

function site_url(url){
	return base_url+'/'+url;
}

var table;
var table_row = null;
$( document ).ready(function() {
	
	if ($('[data-plugin="xeditable"]').length > 0) {
		$('[data-plugin="xeditable"]').each(function () {
			var id = $(this).attr('id');
			$("#" + id).editable();
		});
	}
	
	
	$('[data-download]').click(function () {
		var action = $(this).data('download');
		var download_url = $(this).data('download-url');
		if(action == 'excel'){
			window.open(site_url(download_url),"_Blank");
		}
		if(action == 'pdf'){
			window.open(site_url(download_url),"_Blank");
		}
	});
	
	
	/* form validation */
	if ($('[data-plugin="form-validation"]').length > 0) {
		$('[data-plugin="form-validation"]').each(function () {
			
			
			$.validator.addMethod("date",
			function(value, element) {
				return value.match(/^(0?[1-9]|[12][0-9]|3[0-1])[/., -](0?[1-9]|1[0-2])[/., -](19|20)?\d{2}$/);
			},
			"Please enter a date in the format!"
			);
			
			var id = $(this).attr('id');
			$("#" + id).validate({
				errorElement  : 'span',
				errorClass    : 'help-block has-error',
				errorPlacement: function (error, element) {
					if (element.parents("label").length > 0) {
						element.parents("label").after(error);
						} else {
						element.after(error);
					}
				},
				highlight     : function (label) {
					$(label).closest('.form-group').removeClass('has-error has-success').addClass('has-error');
				},
				success       : function (label) {
					label.addClass('valid').closest('.form-group').removeClass('has-error has-success').addClass('has-success');
				},
				onkeyup       : function (element) {
					$(element).valid();
				},
				onfocusout    : function (element) {
					$(element).valid();
				},
				ignore: [],  // <- proper format to set ignore to "nothing"
				invalidHandler:  function(event, validator) {
					$(".tab-content").find("div.tab-pane:has(div.has-error)").each(function (index, tab) {
						var id = $(tab).attr("id");
						$('a[href="#' + id + '"]').tab('show');
						return false;
					});
				},
				submitHandler: function(form)
				{
					var url = $(form).attr('action');
					var method = $(form).attr('method');
					var success_url = $(form).data('success');
					var datasend = $(form).serialize();
					datasend += '&redirect='+success_url;
					var button_element = $(form).find('button[type="submit"]').html();
					
					$.ajax({
						url			: url,
						type		: method,
						data		: datasend,
						dataType	: 'json',
						beforeSend	: function() {
							$(form).find('[type="submit"]').attr('disabled',true);
							$(form).find('[type="submit"]').prop('disabled',true);
							$(form).find('[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Silahkan Tunggu',true);
						},
						success	: function(jdata){
							if(jdata.status == true)
							{
								swal({
									title: "Success !",
									text: jdata.message,
									type: "success"
									}).then(function() {
									if(jdata.redirect){
										window.location=jdata.redirect;
										} else {
										window.location.reload(); 
									}
								});
							}
							else if(jdata.status == false)
							{
								swal('Gagal !',jdata.message,'error');
							}
							else
							{
								swal('Gagal !','unkwon error','error');
							}
							
							$(form).find('[type="submit"]').removeAttr('disabled');
							$(form).find('[type="submit"]').removeProp('disabled');
							$(form).find('[type="submit"]').html(button_element,true);
						},
						error	: function(){
							$(form).find('[type="submit"]').removeAttr('disabled');
							$(form).find('[type="submit"]').removeProp('disabled');
							$(form).find('[type="submit"]').html(button_element,true);
						}
					}); 
				}
			});
		});
	}
	
	/* select2 autocomplete */
	
	if ($('[data-plugin="select2"]').length > 0) {
		$('[data-plugin="select2"]').select2({
			placeholder: '-- Pilih Data --',
			allowClear: true
		}).append('<option></option>');
	}
	
	
	if ($('[data-plugin="maskmoney"]').length > 0) {
		$("[data-plugin='maskmoney']").maskMoney({prefix:'Rp ', allowNegative: false, thousands:'.', decimal:',', affixesStay: true,  precision : 0}).css('text-align','right');
	}
	
	$('[data-plugin="datepicker"][data-type="date"]').datetimepicker({
		format:'d/m/Y',
		mask:'39/19/2999',
		required :true,
		timepicker:false
	});
	
	$('[data-plugin="datepicker"][type="time"]').datetimepicker({
		format:'H:i',
		mask:'29:59',
		required :true,
		datepicker:false
	});
	
	$('[data-plugin="datepicker"][type="datetime"]').datetimepicker({
		format:'d/m/Y H:i',
		mask:'39/19/2999 29:59',
		required :true
	});
	
	$('[data-action="modal"]').click(function(){
		$('#modal').find('.modal-body').empty();
		$('#modal').modal('show');
		var title = $(this).data('modal-header');
		var content = $(this).data('modal-content');
		var url = $(this).data('modal-url');
		var type = $(this).data('modal-type');
		var width = $(this).data('modal-width');
		console.log('title : '+title);
		console.log('content : '+content);
		console.log('url : '+url);
		console.log('type : '+type);
		
		$('#modal').find('.modal-dialog').css('width',width);
		$('#modal').find('.modal-title').html(title);
		
		if(type == 'alert')
		{
			var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
			$('#modal').find('.modal-body').html(content);
			$('#modal').find('.modal-footer').html(footer);
		}
		else if(type == 'alert_load')
		{
			var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
			$('#modal').find('.modal-body').load(content,function(){$.getScript(base_url+'/assets/theme_1/js/main.js');});
			$('#modal').find('.modal-footer').html(footer);
		}
		else if(type == 'confirm') 
		{
			var footer = '<a type="button" class="btn btn-custom" href="'+url+'">Ya</a>';
			footer += '<button type="button" class="btn btn-custom" data-dismiss="modal">Tidak</button>';
			$('#modal').find('.modal-body').html(content);
			$('#modal').find('.modal-footer').html(footer);
		}
		else if(type == 'form')
		{
			$('[name="modal-form"]').attr('action',url);
			var footer = '<button type="submit" class="btn btn-custom">Simpan</button>';
			footer += '<button type="button" class="btn btn-custom" data-dismiss="modal">Batal</button>';
			$('#modal').find('.modal-body').load(content,function(){$.getScript(base_url+'/assets/theme_1/js/main.js');});
			$('#modal').find('.modal-footer').html(footer);
		}
		else if(type == 'embed')
		{
			var embed = '<embed src="'+content+'" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html" height="400" width="100%">';
			var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
			$('#modal').find('.modal-body').html(embed);
			$('#modal').find('.modal-footer').html(footer);
		}
		else if(type == 'audio')
		{
			var embed = '<center><audio controls="" src="'+content+'" width="100%"></audio></center>';
			var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
			$('#modal').find('.modal-body').html(embed);
			$('#modal').find('.modal-footer').html(footer);
		}
		else if(type == 'video')
		{
			var embed = '<center><video controls="" src="'+content+'" width="100%"></video></center>';
			var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
			$('#modal').find('.modal-body').html(embed);
			$('#modal').find('.modal-footer').html(footer);
		}
		else if(type == 'image')
		{
			var embed = '<center><img src="'+content+'" alt="image" width="100%"></center>';
			var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
			$('#modal').find('.modal-body').html(embed);
			$('#modal').find('.modal-footer').html(footer);
		}
	});
	/* back browser */
	$('[data-action="back"]').click(function(){
		window.history.back();
	});
	$( '[data-trigger="change"]' ).trigger( "change" );
	
	/* DataTables */
	
	var save_method; //for save method string
	var editor;
	
	var table_row = [];
	if ($('[data-plugin="datatable-server-side"]').length > 0) {
		$('[data-plugin="datatable-server-side"]').each(function () {
			var id = $(this).attr('id');
			var $el = $("#" + id),
			dataTable_options = {
				dom: 'lfrtip',
				lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
			},
			no_sort = $el.attr('data-nosort');
			
			var json_list = $el.data('datatable-list');
			var json_edit = $el.data('datatable-edit');
			var json_delete = $el.data('datatable-delete');
			
			dataTable_options.oLanguage = {
				"sProcessing": '<i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span style="margin-top: -10px;" class="loading_menu">Please wait....</span>'
			};
			dataTable_options.processing = true;
			dataTable_options.serverSide = true;
			dataTable_options.order = [];
			dataTable_options.ajax = {
				"url": site_url(json_list),
				"type": "POST",
				"data" :  function ( d ) {
					
					var obj = d;
					
					var param = $('[data-datatable-filter="true"][data-datatable-id="'+id+'"]').serializeArray();
					var new_param = $.map(param, function(n, i)
					{
						var o = {};
						o[n.name] = n.value;
						return o;
					});
					
					obj['custom_filter'] = new_param;
					
					return obj;
				}
			};
			
			dataTable_options.columnDefs = [];
			
			if (no_sort !== undefined) {
				var cols = no_sort.split(',').map(function (col_string) {
					return parseInt(col_string.trim());
				});
				
				dataTable_options.columnDefs.push(
				{
					'orderable': false,
					'targets'  : cols
				}
				);
				
				dataTable_options.order = [];
			}
			
			if ($el.data('datatable-nosearch')) {
				var cols = $el.find('[data-datatable-nosearch]').split(',').map(function (col_string) {
					return parseInt(col_string.trim());
				});
				
				dataTable_options.columnDefs.push(
				{
					'searchable': false,
					'targets'  : cols
				}
				);
				
				dataTable_options.order = [];
			}
			
			if ($el.data('datatable-multiselect')) {
				dataTable_options.columnDefs.push(
				{ 
					"targets": [ 0 ], //last column
					'searchable':false,
					'orderable':false,
					'render': function (data, type, full, meta){
						return '<input type="checkbox" data-datatable-bulk_delete="true" name="id[]" value="' + data + '">';
					}
				}
				);
			}
			
			if ($el.find('[data-datatable-align]')) {
				var x = 0;
				$el.find('[data-datatable-align]').each(function () {
					dataTable_options.columnDefs.push({ "targets": [ x ] , className: $(this).data('datatable-align') });
					x++;
				});
			}
			
			
			/* ColVis */
			if ($el.data('datatable-colvis') !== undefined) {
				dataTable_options.dom = 'C' + dataTable_options.dom;
				
				var $x = ($el.find('th').length)-1;
				dataTable_options.colVis = {
					"buttonText": "Show/hide columns <i class='fa fa-angle-down'></i>",
					"iOverlayFade": 0,       
					"exclude": [ 0 , $x]
				};
			}
			
			if ($el.data('datatable-nocolvis') !== undefined) {
				var cols = $el.data('datatable-nocolvis').split(',').map(function (col_string) {
					return parseInt(col_string.trim());
				});
				
				dataTable_options.columnDefs.push({ visible: false, targets: cols });
			}
			
			if ($el.data("datatable-nosearch") !== undefined) {
				dataTable_options.filter = false;
			}
			if ($el.data("datatable-nopagination") !== undefined) {
				dataTable_options.paging = false;
			}
			if ($el.data("datatable-noinfo") !== undefined) {
				dataTable_options.info = false;
			}
			if ($el.data("datatable-noorder") !== undefined) {
				dataTable_options.ordering = false;
			}
			
			if ($el.data('datatable-tools')) {
				dataTable_options.dom = 'T' + dataTable_options.dom;
				dataTable_options.tableTools = {
					"sSwfPath": "js/plugins/datatables/extensions/copy_csv_xls_pdf.swf"
				};
			}
			
			if ($el.data('datatable-colreorder')) {
				dataTable_options.dom = 'R' + dataTable_options.dom;
			}
			
			if ($el.data("datatable-scroll-x")) {
				dataTable_options.scrollX = "100%";
				dataTable_options.scrollCollapse = true;
			}
			
			if ($el.data("datatable-scroll-y")) {
				dataTable_options.scrollY = "300px";
				dataTable_options.paginate = false;
				dataTable_options.scrollCollapse = true;
			}
			
			if ($el.data("datatable-scroller")) {
				var ajaxSource = $el.attr('data-ajax-source');
				
				if(ajaxSource !== '' && ajaxSource !== undefined){
					if ($el.hasClass('dataTable-tools')) {
						dataTable_options.dom = 'Tfrtip';
					}
					
					dataTable_options.scrollY = "300px";
					dataTable_options.deferRender = true;
					dataTable_options.dom = dataTable_options.dom + 'S';
					dataTable_options.ajax = ajaxSource;
				}
			}
			
			
			if ($el.data('datatable-edit')) {
				dataTable_options.columnDefs.push({ 
					"targets": [ -1 ], //last column
					'searchable':false,
					'orderable':false,
					'render': function (data, type, full, meta){
						var action  = '';
						if(json_edit){
							action += '<button type="button" class="btn" title="Edit" data-datatable-action="edit"  data-datatable-id="'+data+'" rel="tooltip"><i class="fa fa-pencil"></i></button> ';
						}
						return action;
					}
				});
			}
			
			dataTable_options.drawCallback = function(settings, json) {
				if ($el.find('[data-datatable-action="edit"]').length > 0) {
					$el.find('[data-datatable-action="edit"]').each(function () {
						$(this).click(function(){	
							var row_id = $(this).data('datatable-id');							
							save_method = 'update';
							datatable_form(id);
							$.ajax({
								url : site_url(json_edit+'/'+row_id),
								type: "POST",
								dataType: "JSON",
								success: function(data)
								{
									$.each(data.response.data_array,function(i,v){
										
										if($('[name="'+v.name+'"]').attr('type') == 'radio') {
											$('[name="'+v.name+'"][value="' + v.value + '"]').prop("checked","checked");
											$('[name="'+v.name+'"][value="' + v.value + '"]').attr("checked","checked");
										}
										else if($('[name="'+v.name+'"]').is("select")) {
											$('select[name="'+v.name+'"] option').removeProp("selected");
											$('select[name="'+v.name+'"] option').removeAttr("selected");
											$('select[name="'+v.name+'"] option[value="' + v.value + '"]').prop("selected","selected");
											$('select[name="'+v.name+'"] option[value="' + v.value + '"]').attr("selected","selected");

										}
										else if($('[name="'+v.name+'"]').attr('type') == 'checkbox'){
											if(v.value >= 1){
											$('[name="'+v.name+'"]').val(v.value);
											$('[name="'+v.name+'"][value="' + v.value + '"]').prop("checked","checked");
											$('[name="'+v.name+'"][value="' + v.value + '"]').attr("checked","checked");
											}
										}
										else
										{
											$('[name="'+v.name+'"]').val(v.value);
											if($('select[name="'+v.name+'"]').data('plugin') == 'select2') {
												$('select[name="'+v.name+'"]').select2();
											}
										}
										
										$('[name="'+v.name+'"]').trigger('change');
									});
									datatable_modal(id,'Edit Data');
									
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							});
							
							
						});
					});
				}	
				
				$('[data-action="modal"]').click(function(){
					$('#modal').find('.modal-body').empty();
					$('#modal').modal('show');
					var title = $(this).data('modal-header');
					var content = $(this).data('modal-content');
					var url = $(this).data('modal-url');
					var type = $(this).data('modal-type');
					var width = $(this).data('modal-width');
					
					$('#modal').find('.modal-dialog').css('width',width);
					$('#modal').find('.modal-title').html(title);
					
					if(type == 'alert')
					{
						var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
						$('#modal').find('.modal-body').html(content);
						$('#modal').find('.modal-footer').html(footer);
					}
					else if(type == 'alert_load')
					{
						var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
						$('#modal').find('.modal-body').load(content);
						$('#modal').find('.modal-footer').html(footer);
					}
					else if(type == 'confirm') 
					{
						var footer = '<a type="button" class="btn btn-custom" href="'+url+'">Ya</a>';
						footer += '<button type="button" class="btn btn-custom" data-dismiss="modal">Tidak</button>';
						$('#modal').find('.modal-body').html(content);
						$('#modal').find('.modal-footer').html(footer);
					}
					else if(type == 'form')
					{
						$('[name="modal-form"]').attr('action',url);
						var footer = '<button type="submit" class="btn btn-custom">Simpan</button>';
						footer += '<button type="button" class="btn btn-custom" data-dismiss="modal">Batal</button>';
						$('#modal').find('.modal-body').load(content);
						$('#modal').find('.modal-footer').html(footer);
					}
					else if(type == 'embed')
					{
						var embed = '<embed src="'+content+'" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html" height="400" width="100%">';
						var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
						$('#modal').find('.modal-body').html(embed);
						$('#modal').find('.modal-footer').html(footer);
					}
					else if(type == 'audio')
					{
						var embed = '<center><audio controls="" src="'+content+'" width="100%"></audio></center>';
						var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
						$('#modal').find('.modal-body').html(embed);
						$('#modal').find('.modal-footer').html(footer);
					}
					else if(type == 'video')
					{
						var embed = '<center><video controls="" src="'+content+'" width="100%"></video></center>';
						var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
						$('#modal').find('.modal-body').html(embed);
						$('#modal').find('.modal-footer').html(footer);
					}
					else if(type == 'image')
					{
						var embed = '<center><img src="'+content+'" alt="image" width="100%"></center>';
						var footer = '<button type="button" class="btn btn-custom" data-dismiss="modal">Keluar</button>';
						$('#modal').find('.modal-body').html(embed);
						$('#modal').find('.modal-footer').html(footer);
					}
				});
				
				
			};
			
			
			dataTable_options.initComplete = function(settings, json) {
				if ($el.data('datatable-daterange') != undefined) {
					var today = new Date();
					var dd = today.getDate();
					var mm = today.getMonth()+1; //January is 0!
					
					var yyyy = today.getFullYear();
					if(dd<10){
						dd='0'+dd
					} 
					if(mm<10){
						mm='0'+mm
					} 
					var today = dd+'/'+mm+'/'+yyyy;
					
					var ht = '<div id="pasien_filter_date" class="dataTables_filter" style="margin-left: 82px;width: 26%;">';
					ht += '<label style="width: 100%;">';
					ht += 'Tgl:';
					ht += '<input data-datatable-id="'+id+'" data-datatable-filter="true" value="'+today+'" name="datatable_daterange1" id="'+id+'_daterange1" class="form-control input-sm" placeholder="" aria-controls="pasien" style="width: 40%;" type="text" data-plugin="datepicker">';
					ht += '<input data-datatable-id="'+id+'" data-datatable-filter="true" value="'+today+'" name="datatable_daterange2" id="'+id+'_daterange2" class="form-control input-sm" placeholder="" aria-controls="pasien" style="width: 40%;" type="text" data-plugin="datepicker"></label>';
					ht += '</div>'
					var $filter = $('#'+id+'_filter');
					$filter.after(ht);
					
					$('#'+id+'_daterange1').datetimepicker({
						format:'d/m/Y',
						mask:'39/19/2999',
						required :true,
						timepicker:false
					});
					
					$('#'+id+'_daterange2').datetimepicker({
						format:'d/m/Y',
						mask:'39/19/2999',
						required :true,
						timepicker:false
					});
					
					
					$('[data-datatable-filter="true"][data-datatable-id="'+id+'"]').keyup( function() {
						table_row[id].draw();
					} );
					$('[data-datatable-filter="true"][data-datatable-id="'+id+'"]').change( function() {
						table_row[id].draw();
					} );
					
					$('#'+id+'_daterange1, #'+id+'_daterange2').keyup( function() {
						table_row[id].draw();
					} );
					
					$('#'+id+'_daterange1, #'+id+'_daterange2').change( function() {
						table_row[id].draw();
					});
				}
				
			}
			
			table_row[id] = $el.DataTable(dataTable_options).ajax.reload();
			
			
			
			if($el.data('datatable-autorefresh')){
				
				setTimeout(function(){ table_row[id].ajax.reload(); }, 300);
				setInterval (function test() {
					table_row[id].ajax.reload();
				}, 60000);
			}
			
			if ($el.data("datatable-fixedcolumn")) {
				new $.fn.DataTable.FixedColumns( table_row[id] );
			}
			
			
			$el.find('[data-datatable-checkall="true"]').change(function () {
				var $checkbox = $(this),
				col_index = $checkbox.parent().index(),
				nodes;
				
				if ($el.attr('data-checkall') !== 'all') {
					nodes = table_row[id].column(col_index, {page: 'current'}).nodes().to$();
					} else {
					nodes = table_row[id].column(col_index, {page: 'all'}).nodes().to$();
				}
				nodes.find('input[type="checkbox"]').prop('checked', $checkbox.prop('checked'));
			});
			
			if ($('[data-datatable-action="reload"][data-datatable-idtable="'+id+'"]').length > 0) {
				$('[data-datatable-action="reload"][data-datatable-idtable="'+id+'"]').click(function(){
					table_row[id].ajax.reload(null,false); //reload datatable ajax 
				});
			}
			
			if ($('[data-datatable-action="add"][data-datatable-idtable="'+id+'"]').length > 0) {
				$('[data-datatable-action="add"][data-datatable-idtable="'+id+'"]').each(function () {
					$(this).click(function(){
						datatable_form(id);
						datatable_modal(id,'Tambah Data');
						save_method = 'add';
					});
				});
			}
			
			if ($('[data-datatable-action="bulk"][data-datatable-idtable="'+id+'"]').length > 0) {
				$('[data-datatable-action="bulk"][data-datatable-idtable="'+id+'"]').each(function () {
					$(this).click(function(){ // triggering delete one by one
						if( $('[data-datatable-bulk_delete="true"]:checked').length > 0 ){  // at-least one checkbox checked
							save_method = 'delete';
							
							swal({
								title: 'Apa anda yakin ?',
								text: "Data yang sudah di hapus tidak dapat dikembalikan kemabli dengan cara apapun !",
								type: 'warning',
								showCancelButton: true,
								confirmButtonText: 'Hapus',
								confirmButtonColor: '#d33',
								showLoaderOnConfirm: true,
								preConfirm: function(result) {
									return new Promise(function(resolve, reject) {
										if (result) {
											var post_form = $('[data-datatable-bulk_delete="true"]').serialize();
											var hasil = process_delete(post_form,site_url(json_delete));
											if(hasil != false)
											{
												resolve(hasil);
											}
										}
										else {
											reject('Terjadi kesalahan server atau aplikasi !');
										}
									});
								}
								}).then(function(hasil){
								swal({
									title: "Informasi !",
									text: hasil,
									type: 'success'
									}).then(function(){
									table_row[id].ajax.reload(null,false);
								});
							});
						}
						else{
							swal({
								title: "Forbiden !",
								text: 'Harap pilih data yang akan di hapus !',
								type: 'error'
							});
						}
					});
				});
			}
			
			
			if ($('[data-datatable-action="save"][data-datatable-idtable="'+id+'"]').length > 0) {
				$('[data-datatable-action="save"][data-datatable-idtable="'+id+'"]').each(function () {
					
					$(this).validate({
						errorElement  : 'span',
						errorClass    : 'help-block has-error',
						errorPlacement: function (error, element) {
							if (element.parents("label").length > 0) {
								element.parents("label").after(error);
								} else {
								element.after(error);
							}
						},
						highlight     : function (label) {
							$(label).closest('.form-group').removeClass('has-error has-success').addClass('has-error');
						},
						success       : function (label) {
							label.addClass('valid').closest('.form-group').removeClass('has-error has-success').addClass('has-success');
						},
						onkeyup       : function (element) {
							$(element).valid();
						},
						onfocusout    : function (element) {
							$(element).valid();
						},
						submitHandler: function(form)
						{
							var url = $(form).attr('action');
							var method = $(form).attr('method');
							var success_url = $(form).data('success');
							var datasend = $(form).serialize();
							
							$.ajax({
								url			: url,
								type		: method,
								data		: datasend,
								dataType	: 'json',
								beforeSend	: function(){
									$(form).find('button[type="submit"]').html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Saving...'); //change button text
									$(form).find('button[type="submit"]').attr('disabled',true); //set button disable 
								},
								success	: function(jdata){
									if(jdata.status) //if success close modal and reload ajax table
									{
										$('.modal[data-datatable-idtable="'+id+'"]').modal('hide');
										table_row[id].ajax.reload(null,false);
									}
									else
									{
										alert('terjadi error');
									}
									$(form).find('button[type="submit"]').html('<i class="fa fa-save fa-fw"></i> Simpan'); //change button text
									$(form).find('button[type="submit"]').attr('disabled',false); //set button enable 
								},
								error : function(jdata){
									$(form).find('button[type="submit"]').html('<i class="fa fa-save fa-fw"></i> Simpan'); //change button text
									$(form).find('button[type="submit"]').attr('disabled',false); //set button enable 
								}
							});
						}
					});
				});
			}
			
		});
		
		
		function process_delete(post_form,json_delete){
			var hasil ;
			$.ajax({
				async: false,
				type: "POST",
				url: json_delete,
				data: post_form, 
				success:function(data){
					hasil = 'Data telah berhasil di hapus !';
				},
				error: function(data){
					alert('Terjadi kesalahan server atau aplikasi !');
					hasil = false;
				}
			});
			return hasil;
		}
		
		
		function datatable_form(id){
			$('form[data-datatable-idtable="'+id+'"]')[0].reset(); // reset form on modals
			$('form[data-datatable-idtable="'+id+'"] .form-group').removeClass('has-error'); // clear error class
			$('form[data-datatable-idtable="'+id+'"] .help-block').remove(); // clear error string
		}
		
		function datatable_modal(id,action){
			$('.modal[data-datatable-idtable="'+id+'"]').modal('show'); // show bootstrap modal
			$('.modal[data-datatable-idtable="'+id+'"] .modal-title #modal_title').text(action); // Set Title to Bootstrap modal title
		}
		
	}
	
});	
function table_reload(id){
	table_row[id].ajax.reload();
}