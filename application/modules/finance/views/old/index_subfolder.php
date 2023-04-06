<?php
    $ENABLE_ADD     = has_permission('Folders.Add');
    $ENABLE_MANAGE  = has_permission('Folders.Manage');
    $ENABLE_VIEW    = has_permission('Folders.View');
    $ENABLE_DELETE  = has_permission('Folders.Delete');
	$ENABLE_DOWNLOAD  = has_permission('Folders.Download');
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">     
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?=$title;?></h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead style="color:white">
				<tr>
				  <th>No</th>
				  <th>Nama Folder</th>
				  <th>Sub Folder I</th>
				  <th>Sub Folder II</th>
				  <th>Sub Folder III</th>
				  <th>Revisi</th>
				  <th>Created On</th>
				  <th align="center">Option</th>
				</tr>
			</thead>
			<tbody>
			  <?php 
			  if($row){
					$int	=0;
					foreach($row as $datas){
						$int++;
						$tgl =date_create($datas->created);
						echo"<tr>";	
						    echo "<td>".$int."</td>";
                            echo "<td>".$datas->nama_master."</td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td>".$datas->created."</td>";
							echo"<td align='left'>";
							
							echo"</td>";
   						    echo"</tr>";
							
					 $where1    =array('id_master'=>$datas->id_master, 'status_approve'=>'2');		
					 $row1		= $this->Folders_model->getDataApprove('gambar',$where1);
					 
					 if($row1){
					 $int1	=0;
					 foreach($row1 as $datas1){
						$int1++;
						echo"<tr>";	
						    echo "<td></td>";
                            echo "<td></td>";
							echo "<td>".$datas1->deskripsi."</td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td>".$datas1->revisi."</td>";
							echo "<td>".$datas1->created."</td>";
							echo"<td align='left'>";
							if($ENABLE_VIEW){	?>
                           <!-- <a href="#" onClick="window.open('<?php echo site_url();?>assets/files/<?php //echo "$datas1->nama_file"; ?>', '_blank')"  class="btn btn-sm btn-success" title="View Data"><i class="fa fa-eye"></i><a/>	-->		
                             <a href="#" class="btn btn-sm btn-primary view"title="View Data" data-id="<?php echo $datas1->id ?>" data-file="<?php echo $datas1->nama_file ?>" data-table="gambar"> <i class="fa fa-eye"></i><a/>							   
							
							
							<?php
							}
							if($ENABLE_DOWNLOAD){
							echo"<a href='".site_url('dokumen/download/'.$datas1->id)."' class='btn btn-sm btn-primary' title='Download Data' data-role='qtip'><i class='fa fa-download'></i></a>";
							
							}
							
							echo"</td>";
   						    echo"</tr>";
							
								$where2    =array('id_detail'=>$datas1->id, 'status_approve'=>'2');		
								$row2		= $this->Folders_model->getDataApprove('gambar1',$where2);
								 
								 if($row2){
								 $int1	=0;
								 foreach($row2 as $datas2){
									$int1++;
									echo"<tr>";	
										echo "<td></td>";
										echo "<td></td>";
										echo "<td>".$datas1->deskripsi."</td>";
										echo "<td>".$datas2->deskripsi."</td>";
										echo "<td></td>";
										echo "<td>".$datas2->revisi."</td>";
										echo "<td>".$datas2->created."</td>";
										echo"<td align='left'>";
										if($ENABLE_VIEW){	?>
										<!--<a href="#" onClick="window.open('<?php echo site_url();?>assets/files/<?php //echo "$datas2->nama_file"; ?>', '_blank')"  class="btn btn-sm btn-success" title="View Data"><i class="fa fa-eye"></i><a/>-->				
										 <a href="#" class="btn btn-sm btn-primary view"title="View Data" data-id="<?php echo $datas2->id ?>" data-file="<?php echo $datas2->nama_file ?>" data-table="gambar1"> <i class="fa fa-eye"></i><a/>	
										 
										<?php
										}
							            if($ENABLE_DOWNLOAD){
										echo"<a href='".site_url('dokumen/download_detail1/'.$datas2->id)."' class='btn btn-sm btn-primary' title='Download Data' data-role='qtip'><i class='fa fa-download'></i></a>";
										
										}
										
										echo"</td>";
										echo"</tr>";
										
										$where3    =array('id_detail1'=>$datas2->id, 'status_approve'=>'2');	
										$row3		= $this->Folders_model->getDataApprove('gambar2',$where3);
										 
										 if($row3){
										 $int1	=0;
										 foreach($row3 as $datas3){
											$int1++;
											echo"<tr>";	
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>".$datas1->deskripsi."</td>";
												echo "<td>".$datas2->deskripsi."</td>";
												echo "<td>".$datas3->deskripsi."</td>";
												echo "<td>".$datas3->created."</td>";
												echo "<td>".$datas3->revisi."</td>";
												echo"<td align='left'>";
												if($ENABLE_VIEW){	?>
												<!--<a href="#" onClick="window.open('<?php echo site_url();?>assets/files/<?php //echo "$datas3->nama_file"; ?>', '_blank')"  class="btn btn-sm btn-success" title="View Data"><i class="fa fa-eye"></i><a/>-->

                                                 <a href="#" class="btn btn-sm btn-primary view"title="View Data" data-id="<?php echo $datas3->id ?>" data-file="<?php echo $datas3->nama_file ?>" data-table="gambar2"> <i class="fa fa-eye"></i><a/>													
												
												<?php
												}
							                    if($ENABLE_DOWNLOAD){
												echo"<a href='".site_url('dokumen/download_detail2/'.$datas3->id)."' class='btn btn-sm btn-primary' title='Download Data' data-role='qtip'><i class='fa fa-download'></i></a>";
												
												
												}
												
												echo"</td>";
												echo"</tr>";
										  }
										 
										 }
								  }
								 
								 }
					  }
					 
					 }
					 
					
						

					}
			  }
			  ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
 </div>
  <!-- /.box -->
  
   <form id="form-modal" action="" method="post">
  <div class="modal fade" id="ModalView">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="head_title"></h4>
        </div>
        <div class="modal-body" id="view">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ModalView2">
    <div class="modal-dialog" style='width:30%; '>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="head_title2"></h4>
        </div>
        <div class="modal-body" id="view2">
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-primary">Save</button> -->
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ModalView3">
    <div class="modal-dialog" style='width:30%; '>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="head_title3"></h4>
        </div>
        <div class="modal-body" id="view3">
        </div>
        <div class="modal-footer">
          <!--<button type="button" class="btn btn-primary">Save</button>-->
          <button type="button" class="btn btn-default close3" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
</form>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<script>

    $('#example1').DataTable( {
	        orderCellsTop: false,
	        fixedHeader: true,
			scrollX:true,
			ordering: false,
			info:     false
	    } );
	
	$(document).ready(function(){
		$('#btn-add').click(function(){
			loading_spinner();
		});
		
	});
	function delData(id){
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
					loading_spinner();
					window.location.href = base_url +'index.php/'+ active_controller+'/delete/'+id;
					
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				return false;
			  }
		});
       
	} 
	
	   $(document).on('click', '.view', function(e) {
		  var id = $(this).data('id');
		  var table = $(this).data('table'); 
          var file = $(this).data('file'); 		  
		
     
      $.ajax({
        type: "post",
        url: siteurl + active_controller + 'history_revisi/',
        
	    data: "id="+id+"&table="+table+"&file="+file,
        success: function(result) {
          $(".modal-dialog").css('width', '90%'); 
          $("#head_title").html("<b>VIEW DATA</b>");
          $("#view").html(result);
          $("#ModalView").modal('show');
        }
      })
    });
</script>