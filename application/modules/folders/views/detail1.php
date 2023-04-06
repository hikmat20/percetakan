<?php
    $ENABLE_ADD     = has_permission('Folders.Add');
    $ENABLE_MANAGE  = has_permission('Folders.Manage');
    $ENABLE_VIEW    = has_permission('Folders.View');
    $ENABLE_DELETE  = has_permission('Folders.Delete');
?>   
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">     
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?=$title;?></h3>
		<div class="box-tool pull-right">
		<?php
			if($ENABLE_ADD){
		?>
		  <a href="<?php echo site_url('folders/add_detail1?id_detail='.$dtl) ?>" class="btn btn-sm btn-success" id='btn-add'>
			<i class="fa fa-plus"></i> Add
		  </a>
		  <a href="<?php echo site_url('folders/detail?id_master='.$mtr) ?>" class="btn btn-sm btn-success" id='btn-add'>
			<i class="fa fa-mail-reply"></i> Kembali
		  </a>
		  <?php
			}
		  ?>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead style="color:white">
				<tr>
				  <th>No</th>
				  <th>Deskripsi</th>
				  <th>Nama File</th>
				  <th>Ukuran File</th>
				  <th>Tipe File</th>
				  <th>Revisi</th>
				 
				  <th>Status Approval</th>
				  <th align="center">Sub Detail</th>
				  <th align="center">Option</th>
				</tr>
			</thead>
			<tbody>
			  <?php 
			  if($row){
				  
				  $int	=0;
					foreach($row as $datas){
						$int++;
						if($datas->status_approve=='0'){
						 $approve1 = 'Revisi';
						 }
						 else if($datas->status_approve=='1'){
						 $approve1 = 'Waiting Approval';
						 }
						 else if($datas->status_approve=='2'){
						 $approve1 = 'Approval';
						 }
						  else if($datas->status_approve=='3'){
						 $approve1 = 'Waiting Review';
						 }
						 
							
							
						
						echo"<tr>";	
						    echo "<td>".$int."</td>";
                            echo "<td>".$datas->deskripsi."</td>";
						    echo "<td>".$datas->nama_file."</td>";
							echo "<td>".$datas->ukuran_file." kB</td>";
							echo "<td>".$datas->tipe_file."</td>";
							echo "<td>".$datas->revisi."</td>";
							 $dtid = $datas->id;
							  $appr = $this->db->query("SELECT approval_on as tgl_dt, keterangan as ket_dt FROM tbl_approval WHERE id_dokumen ='$dtid' AND nm_table='gambar1'")->result_array();		  
							  
							 
								if(!empty($appr)) {
								$approval = array();
								foreach($appr as $val => $apr) {
									$tglappr =$apr['tgl_dt'];
									$ketappr =$apr['ket_dt'];
									$br ='<br>';
									$approval[] =  '- '.$tglappr.'/'.$ketappr.'<br>';
								} 
								$appr2 = implode("",$approval);
								
							
							   // echo "<td >".$appr2."</td>";
								}
								
								else{
							    //echo "<td ></td>";	
				             	}					
							echo "<td>".$approve1."</td>";
							echo"<td align='center'>";
							// if($ENABLE_MANAGE){	?>
                           						
							 <?php
							// echo"<a href='".site_url('folders/add_subdetail2/'.$datas->id.'/'.$datas->id_master)."' class='btn btn-sm btn-primary' title='Tambah Sub Dokumen' data-role='qtip'><i class='fa fa-plus'></i></a>";
							// }
							
							if ($ENABLE_VIEW){	
							echo"<a href='".site_url('folders/detail2?id_detail1='.$datas->id)."' class='btn btn-sm btn-primary' title='Buka Folder' data-role='qtip'><i class='fa fa-folder-open'></i></a>";
							}
							
							echo"</td>";
							echo"<td align='left'>";
							if($ENABLE_MANAGE){	?>
                            <a href="#" onClick="window.open('<?php echo site_url();?>assets/files/<?php echo "$datas->nama_file"; ?>', '_blank')"  class="btn btn-sm btn-success" title="View Data"><i class="fa fa-eye"></i><a/>							
							
							<?php
							echo"<a href='".site_url('folders/download_detail1/'.$datas->id)."' class='btn btn-sm btn-primary' title='Download Data' data-role='qtip'><i class='fa fa-download'></i></a>";
							?>
							
							<a href="#" class="btn btn-sm btn-warning edit"title="Revisi Data" data-file="<?php echo $datas->nama_file ?>" data-id="<?php echo $datas->id ?>" data-table="gambar1"><i class="fa fa-edit"></i><a/>
							
							
							<?php
							}
							if($ENABLE_DELETE){ 
                          	echo"&nbsp;<a href='".site_url('folders/delete_detail1/'.$datas->id)."' class='btn btn-sm btn-danger' title='Delete Data' data-role='qtip'><i class='fa fa-trash'></i></a>";
							}
							echo"</td>";
   						    echo"</tr>";

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
	$(document).ready(function(){
		$('#btn-add').click(function(){
			loading_spinner();
		});
		
	});
	
	
    $('#example1').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true,
			scrollX:true
	    } );
		
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
					window.location.href = base_url +'index.php/'+ active_controller+'/delete_sub1/'+id;
					
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				return false;
			  }
		});
       
	} 
	
	 $(document).on('click', '.edit', function(e) {
		  var id = $(this).data('id');
		  var table = $(this).data('table'); 
          var file = $(this).data('file'); 		  
		 
      $.ajax({
        type: "post",
        url: siteurl + active_controller + 'revisi/',
        
	    data: "id="+id+"&table="+table+"&file="+file,
        success: function(result) {
          $(".modal-dialog").css('width', '90%'); 
          $("#head_title").html("<b>REVISI</b>");
          $("#view").html(result);
          $("#ModalView").modal('show');
        }
      })
    });	
</script>

