<?php
    $ENABLE_ADD     = has_permission('Folders.Add');
    $ENABLE_MANAGE  = has_permission('Folders.Manage');
    $ENABLE_VIEW    = has_permission('Folders.View');
    $ENABLE_DELETE  = has_permission('Folders.Delete');
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
						    echo form_input(array('type'=>'hidden','id'=>'id_detail1','name'=>'id_detail1','class'=>'form-control input-sm','value'=>$iddetail1,'placeholder'=>'Id Detail1'));
							echo form_input(array('type'=>'hidden','id'=>'id_detail','name'=>'id_detail','class'=>'form-control input-sm','value'=>$iddetail,'placeholder'=>'Id Detail'));
							echo form_input(array('type'=>'hidden','id'=>'id_master','name'=>'id_master','class'=>'form-control input-sm','value'=>$idmaster,'placeholder'=>'Id Master'));
							echo form_input(array('id'=>'deskripsi','name'=>'deskripsi','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Deskripsi'));							
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
			<div class='form-group row'>
			<label class='label-control col-sm-2'><b>Prepared By<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
					    <span class="input-group-addon"><i class="fa fa-user"></i></span>   
						<select name="prepared_by" id="prepared_by" class="form-control input-md select2">";
						<option value="0">Pilih User</option><?=$results['users']?>
						</select>
					</div>
					
							
				</div>
			</div>	
			<div class='form-group row'>
			<label class='label-control col-sm-2'><b>Review<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group" id="select_review">
						<span class="input-group-addon"><i class="fa fa-check"></i></span>              
						<select class="form-control input-sm select2" name="id_review" id="id_review">
						<option value="">Pilih Review</option>								
						</select> 
					</div>
							
				</div>					
			<label class='label-control col-sm-2'><b>Approval <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group" id="select_approval">
						<span class="input-group-addon"><i class="fa fa-check"></i></span>              
						<select class="form-control input-sm select2" name="id_approval" id="id_approval">
						<option value="">Pilih Approval</option>								
						</select> 
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
		get_approval();
		get_review();
		$('.select2').select2();
		$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image		= $('#image').val();
			var id_master   = $('#id_master').val();
			var id_detail1  = $('#id_detail1').val();
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
						var baseurl=base_url + active_controller +'add_detail2';
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
									window.location.href = base_url + active_controller+'detail2?id_detail='+id_detail1;
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
	
	function back(){	
	var id_detail1 =$('#id_detail1').val();
	window.location.href = base_url + active_controller+'detail2?id_detail='+id_detail1;
	}
	
	function get_review(){
       
		$.ajax({
            type:"GET",
            url:siteurl+'folders/get_review',
            data:"",
            success:function(html){
               $("#select_review").html(html);
            }
        });
	}
	
	function get_approval(){
       
		$.ajax({
            type:"GET",
            url:siteurl+'folders/get_approval',
            data:"",
            success:function(html){
               $("#select_approval").html(html);
            }
        });
	}
</script>
