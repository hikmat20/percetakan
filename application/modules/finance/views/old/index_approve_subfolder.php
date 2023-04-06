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
		<input type="hidden" id="uri1" name="uri1" value="<?php echo $this->uri->segment(1) ?>" />
		<input type="hidden" id="uri2" name="uri2" value="<?php echo $this->uri->segment(2) ?>" />
		<input type="hidden" id="uri3" name="uri3" value="<?php echo $this->uri->segment(3) ?>" />
		<input type="hidden" id="uri4" name="uri4" value="<?php echo $this->uri->segment(4) ?>" />
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
				  <th>Rev</th>
				  <th>History Rev</th>
				  <th>Status Approval</th>
				  <th>Created On</th>
				  <th align="center">Option</th>
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
						    echo "<td>".$int."</td>";
                            echo "<td>".$datas->nama_master."</td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td>".$datas->created."</td>";
							echo"<td align='left'>";
							
							echo"</td>";
   						    echo"</tr>";
					
					 $where1    =array('id_master'=>$datas->id_master);		
					 $row1		= $this->Folders_model->getDataApprove('gambar',$where1);
					 
					
					 
					 if($row1){
					 $int1	=0;
					 foreach($row1 as $datas1){
						 if($datas1->status_approve=='0'){
						 $approve1 = 'Revisi';
						 }
						 else if($datas1->status_approve=='1'){
						 $approve1 = 'Waiting Approval';
						 }
						$int1++;
						echo"<tr>";	
						    echo "<td></td>";
                            echo "<td></td>";
							echo "<td>".$datas1->deskripsi."</td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td>".$datas1->revisi."</td>";
							 $dtid = $datas1->id;
							  $appr = $this->db->query("SELECT approval_on as tgl_dt, keterangan as ket_dt FROM tbl_approval WHERE id_dokumen ='$dtid' AND nm_table='gambar'")->result_array();		  
							  							 
							if(!empty($appr)) {
								$approval = array();
								foreach($appr as $val => $apr) {
									$tglappr =$apr['tgl_dt'];
									$ketappr =$apr['ket_dt'];
									$br ='<br>';
									$approval[] =  '- '.$tglappr.'/'.$ketappr.'<br>';
								} 
								$appr2 = implode("",$approval);
								
							
							    echo "<td>".$appr2."</td>";
								}
								
								else{
							    echo "<td></td>";	
				             	}						
							echo "<td>".$approve1."</td>";
							echo "<td>".$datas1->created."</td>";
							echo"<td align='left'>";
							if($ENABLE_VIEW){	
							if($datas1->status_approve=='1' ){	?>
                            <a href="#" onClick="window.open('<?php echo site_url();?>assets/files/<?php echo "$datas1->nama_file"; ?>', '_blank')"  class="btn btn-sm btn-warning approve"title="Approve Data" data-id="<?php echo $datas1->id ?>" data-table="gambar"> <i class="fa fa-check"></i><a/>							
							
							
							<?php
							}
							}
							// if($ENABLE_DOWNLOAD){
							// echo"<a href='".site_url('dokumen/download/'.$datas1->id)."' class='btn btn-sm btn-primary' title='Download Data' data-role='qtip'><i class='fa fa-download'></i></a>";
							
							// }
							
							echo"</td>";
   						    echo"</tr>";
							    
								$where2    =array('id_detail'=>$datas1->id, 'status_approve !='=>'2');		
								$row2		= $this->Folders_model->getDataApprove('gambar1',$where2);
								 
								 if($row2){
								 $int1	=0;
								 foreach($row2 as $datas2){
									 
									 if($datas2->status_approve=='0'){
									 $approve2 = 'Revisi';
									 }
									 else if($datas2->status_approve=='1'){
									 $approve2 = 'Waiting Approval';
									 }
					 
					 
									$int1++;
									echo"<tr>";	
										echo "<td></td>";
										echo "<td></td>";
										echo "<td>".$datas1->deskripsi."</td>";
										echo "<td>".$datas2->deskripsi."</td>";
										echo "<td></td>";
										echo "<td>".$datas2->revisi."</td>";
							  $dtid1 = $datas2->id;
							  $appr1 = $this->db->query("SELECT approval_on as tgl_dt, keterangan as ket_dt FROM tbl_approval WHERE id_dokumen ='$dtid1' AND nm_table='gambar1'")->result_array();		  
							  							 
							if(!empty($appr1)) {
								$approval1 = array();
								foreach($appr1 as $val1 => $apr1) {
									$tglappr1 =$apr1['tgl_dt'];
									$ketappr1 =$apr1['ket_dt'];
									$br1 ='<br>';
									$approval1[] =  '- '.$tglappr1.'/'.$ketappr1.'<br>';
								} 
								$appr21 = implode("",$approval1);
								
							
							    echo "<td>".$appr21."</td>";
								}
								
								else{
							    echo "<td></td>";	
				             	}						
							            echo "<td>".$approve2."</td>";
										echo "<td>".$datas2->created."</td>";
										echo"<td align='left'>";
										if($ENABLE_VIEW){

										if($datas2->status_approve=='1' && $datas2->id_approval==$idjabatan){?>
										<a href="#" onClick="window.open('<?php echo site_url();?>assets/files/<?php echo "$datas2->nama_file"; ?>', '_blank')"  class="btn btn-sm btn-warning approve" title="Approve Data" data-id="<?php echo $datas2->id ?>" data-table="gambar1"><i class="fa fa-check"></i><a/>							
										
										<?php
										}
										}
							            // if($ENABLE_DOWNLOAD){
										// echo"<a href='".site_url('dokumen/download_detail1/'.$datas2->id)."' class='btn btn-sm btn-primary' title='Download Data' data-role='qtip'><i class='fa fa-download'></i></a>";
										
										// }
										
										echo"</td>";
										echo"</tr>";
										
										$where3    =array('id_detail1'=>$datas2->id, 'status_approve!='=>'2');	
										$row3		= $this->Folders_model->getDataApprove('gambar2',$where3);
										 
										 if($row3){
										 $int1	=0;
										 foreach($row3 as $datas3){
											 if($datas3->status_approve=='0'){
											 $approve3 = 'Revisi';
											 }
											 else if($datas3->status_approve=='1'){
											 $approve3 = 'Waiting Approval';
											 }
											$int1++;
											echo"<tr>";	
												echo "<td></td>";
												echo "<td></td>";
												echo "<td>".$datas1->deskripsi."</td>";
												echo "<td>".$datas2->deskripsi."</td>";
												echo "<td>".$datas3->deskripsi."</td>";
												echo "<td>".$datas3->revisi."</td>";
							  $dtid2 = $datas3->id;
							  $appr2 = $this->db->query("SELECT approval_on as tgl_dt, keterangan as ket_dt FROM tbl_approval WHERE id_dokumen ='$dtid2' AND nm_table='gambar2'")->result_array();		  
							  							 
							if(!empty($appr1)) {
								$approval1 = array();
								foreach($appr1 as $val1 => $apr1) {
									$tglappr1 =$apr1['tgl_dt'];
									$ketappr1 =$apr1['ket_dt'];
									$br1 ='<br>';
									$approval1[] =  '- '.$tglappr1.'/'.$ketappr1.'<br>';
								} 
								$appr21 = implode("",$approval1);
								
							
							    echo "<td>".$appr21."</td>";
								}
								
								else{
							    echo "<td></td>";	
				             	}	
							                    echo "<td>".$approve3."</td>";
												echo "<td>".$datas3->created."</td>";
												echo"<td align='left'>";
												if($ENABLE_VIEW){	
												if($datas3->status_approve=='1' && $datas3->id_approval==$idjabatan){?>
												<a href="#" onClick="window.open('<?php echo site_url();?>assets/files/<?php echo "$datas3->nama_file"; ?>', '_blank')"  class="btn btn-sm btn-warning approve" title="Approve Data" data-id="<?php echo $datas3->id ?>" data-table="gambar2">><i class="fa fa-check"></i><a/>							
												
												<?php
												}
												}
							                    // if($ENABLE_DOWNLOAD){
												// echo"<a href='".site_url('dokumen/download_detail2/'.$datas3->id)."' class='btn btn-sm btn-primary' title='Download Data' data-role='qtip'><i class='fa fa-download'></i></a>";
												
												
												// }
												
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
	
	   $(document).on('click', '.approve', function(e) {
		  var id = $(this).data('id');
		  var table = $(this).data('table');  
		  var uri1      = $('#uri1').val();
		  var uri2      = $('#uri2').val();
		  var uri3      = $('#uri3').val();
		  var uri4      = $('#uri4').val();
     
      $.ajax({
        type: "post",
        url: siteurl + active_controller + 'approval/'+uri1+'/'+uri2+'/'+uri3+'/'+uri4,
        
	    data: "id="+id+"&table="+table,
        success: function(result) {
          $(".modal-dialog").css('width', '90%'); 
          $("#head_title").html("<b>APPROVAL</b>");
          $("#view").html(result);
          $("#ModalView").modal('show');
        }
      })
    });
</script>