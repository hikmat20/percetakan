<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> Embed Document </title>
 </head>
 <body>
<table width="100%" border=2>
<tr>
	<td valign="top" width="30%">
		<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
 <form id="form_proses_bro" method="post">
<div class="nav-tabs-salesorder">
     <div class="tab-content">
        <div class="tab-pane active" id="salesorder">			
            <div class="box box-success">
               	<?php 
				
				 if($row){
					foreach($row as $datas){					
						
					$deskripsi = $datas->deskripsi;
					$idmaster  = $datas->id_master;
					
					}
				 }
					?>
				
				   
								
                <div class="box-body">
				<h3></h3>
				         
						 
                    
					   
                            <div class="box-body">
                           
							 </div>
                            <div class="box-body">
							   <input type="hidden" id="id" name="id" value="<?=(isset($id)?$id:'0')?>" />
							   <input type="hidden" id="table" name="table" value="<?=(isset($table)?$table:'-')?>" />
							   <input type="hidden" id="uri1" name="uri1" value="<?php echo $uri3 ?>" />
							   <input type="hidden" id="uri2" name="uri2" value="<?php echo $uri4 ?>" />
							   <input type="hidden" id="uri3" name="uri3" value="<?php echo $uri5 ?>" />
							   <input type="hidden" id="uri4" name="uri4" value="<?php echo $uri6 ?>" />
							   
                               
                            </div>
						
						  <div class="box-body">
                            <label for="deskripsi" class="col-sm-4 control-label">Nama Dokumen </font></label>
                           
                          </div>
						  <div class="box-body">
                              <input name="deskripsi" class="form-control input-sm" id="deskripsi" value="<?= $deskripsi ?>"; readonly >   							  
                            </div>
                        
                         	
                          <div class="box-body">
                            <label for="deskripsi" class="col-sm-4 control-label">Item Perubahan </font></label>
                           
                          </div>
						  <div class="box-body">
                              <textarea name="keterangan" class="form-control input-sm" id="keterangan" valign="top"  align="left"  height="50"></textarea>            							  
                            </div>
							
							<div class="box-body">
                            <label for="image" class="col-sm-4 control-label">Upload Dokumen </font></label>
                           
                          </div>
						   <div class="box-body">
							<?php
							echo form_input(array('type'=>'file','id'=>'image','name'=>'image','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Image'));						
						    ?>
                            </div>
	                						  
                       
                       
            
		    </div>
			      
	</div>
   </div>
</div>
</form>

        <div class='box-footer'>
			<?php
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Save','id'=>'simpan-com')).' ';
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-danger','value'=>'back','content'=>'Back','onClick'=>'javascript:back()'));
			?>
		</div>


 <script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
 <script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
  <script src="<?= base_url('assets/js/jquery.maskMoney.js')?>"></script>
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
									window.location.href = base_url + active_controller;
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
	<td><iframe src='<?php echo site_url();?>assets/files/<?php echo "$nama_file"; ?>' width='100%' height='565px' frameborder='0'> </iframe></td>
</tr>
</table>
 </body>
</html>