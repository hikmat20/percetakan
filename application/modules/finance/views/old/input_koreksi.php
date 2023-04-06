<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> Embed Document </title>
 </head>
 <body>
<table width="100%" border=2>
<tr>
	<td valign="top">
		<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="nav-tabs-salesorder">
     <div class="tab-content">
        <div class="tab-pane active" id="salesorder">			
            <div class="box box-success">
               	<?php //print_r($kode_customer)?>
				<div class="box-body">
				<h3>History Koreksi</h3>
			<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th>No Revisi</th>
				  <th>Keterangan</th>
				</tr>
			</thead> 
		 	<tbody>
			  <?php 
			  $idjabatan = $jabatan;
			
			  if($row){
					$int	=0;
					foreach($row as $datas){
						$int++;
						$tgl =date_create($datas->created);
						echo"<tr>";	
						   	echo "<td>".$datas->revisi."</td>";
                            echo "<td>".$datas->keterangan."</td>";
						echo"</tr>";
				    }
			  }else{
			  echo"Tidak ada history";	
			  }
				
							
			   ?>
			  </tbody>
			</table>
		</div>
               <?php
    $ENABLE_ADD     = has_permission('Folders.Add');
    $ENABLE_MANAGE  = has_permission('Folders.Manage');
    $ENABLE_VIEW    = has_permission('Folders.View');
    $ENABLE_DELETE  = has_permission('Folders.Delete');
	
	foreach($data as $dt){
		$deskripsi = $dt->deskripsi;
		$idmaster  = $dt->id_master;
	}
?>   
<form action="#" method="POST" id="form_proses_bro">   
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?=$title;?></h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Deskripsi<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calculator"></i></span>              
						<?php
							echo form_input(array('type'=>'hidden','id'=>'id','name'=>'id','class'=>'form-control input-sm','value'=>$id,'placeholder'=>'Id'));
							echo form_input(array('type'=>'hidden','id'=>'id_master','name'=>'id_master','class'=>'form-control input-sm','value'=>$idmaster,'placeholder'=>'Id Master'));
							echo form_input(array('id'=>'deskripsi','name'=>'deskripsi','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Deskripsi','value'=>$deskripsi,));	
							echo form_input(array('type'=>'hidden','id'=>'table','name'=>'table','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Table','value'=>$table,));							
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Document <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-image"></i></span>              
						<?php
							echo form_input(array('type'=>'file','id'=>'image','name'=>'image','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Image'));						
						?>
					</div>
							
				</div>
				
			</div>
		</div>
		<div class='box-footer'>
			<?php
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Save','id'=>'simpan-com')).' ';
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-danger','value'=>'back','content'=>'Back','onClick'=>'javascript:back()'));
			?>
		</div>
		<!-- /.box-body -->
	 </div>
  <!-- /.box -->
</form>

<script>
	$(document).ready(function(){
		$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var tabel	    = $('#table').val();
			var image		= $('#image').val();
			var id_master   = $('#id_master').val();
			if(deskripsi=='' || deskripsi==null){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty deskripsi, please input deskripsi  first.....',
				  type	: "warning"
				});
				
				return false;
			}
			
			swal({
				  title: "Are you sure?",
				  text: "You will not be able to process again this data!",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-danger",
				  confirmButtonText: "Yes, Process it!",
				  cancelButtonText: "No, cancel process!",
				  closeOnConfirm: true,
				  closeOnCancel: false
				},
				function(isConfirm) {
				  if (isConfirm) {
						var formData 	=new FormData($('#form_proses_bro')[0]);
						if(tabel=='gambar'){
						var baseurl=base_url + active_controller +'/simpan_koreksi';
						}
						else if(tabel=='gambar1'){
						var baseurl=base_url + active_controller +'/simpan_koreksi1';
						}
						else if(tabel=='gambar2'){
						var baseurl=base_url + active_controller +'/simpan_koreksi2';
						}
						$.ajax({
							url			: baseurl,
							type		: "POST",
							data		: formData,
							cache		: false,
							dataType	: 'json',
							processData	: false, 
							contentType	: false,				
							success		: function(data){								
								if(data.status == 1){											
									swal({
										  title	: "Save Success!",
										  text	: data.pesan,
										  type	: "success",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									window.location.href = base_url + active_controller+'koreksi';
								}else{
									
									if(data.status == 2){
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}else{
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}
									
								}
							},
							error: function() {
								
								swal({
								  title				: "Error Message !",
								  text				: 'An Error Occured During Process. Please try again..',						
								  type				: "warning",								  
								  timer				: 7000,
								  showCancelButton	: false,
								  showConfirmButton	: false,
								  allowOutsideClick	: false
								});
							}
						});
				  } else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				  }
			});
		});
	});
</script>

	</td>
	
</tr>
</table>
 </body>
</html>