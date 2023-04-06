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
		  <a href="<?php echo site_url('folders/add_detail2?id_detail1='.$dtl1) ?>" class="btn btn-sm btn-success" id='btn-add'>
			<i class="fa fa-plus"></i> Add
		  </a>
		  <a href="<?php echo site_url('folders/detail1?id_detail='.$dtl) ?>" class="btn btn-sm btn-success" id='btn-add'>
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
			<thead>
				<tr>
				  <th>No</th>
				  <th>Deskripsi</th>
				  <th>Nama File</th>
				  <th>Ukuran File</th>
				  <th>Tipe File</th>
				  <th align="center">Option</th>
				</tr>
			</thead>
			<tbody>
			  <?php 
			  if($row){
				  
				  $int	=0;
					foreach($row as $datas){
						$int++;
						
						echo"<tr>";	
						    echo "<td>".$int."</td>";
                            echo "<td>".$datas->deskripsi."</td>";
						    echo "<td>".$datas->nama_file."</td>";
							echo "<td>".$datas->ukuran_file." kB</td>";
							echo "<td>".$datas->tipe_file."</td>";
							//echo"<td align='left'>";
							// if($ENABLE_MANAGE){	?>
                           						
							 <?php
							// echo"<a href='".site_url('folders/add_subdetail2/'.$datas->id.'/'.$datas->id_master)."' class='btn btn-sm btn-primary' title='Tambah Sub Dokumen' data-role='qtip'><i class='fa fa-plus'></i></a>";
							// }
							
							// if ($ENABLE_VIEW){	
							// echo"<a href='".site_url('folders/detail3?id_detail1='.$datas->id)."' class='btn btn-sm btn-primary' title='Buka Folder' data-role='qtip'><i class='fa fa-folder-open'></i></a>";
							// }
							
							//echo"</td>";
							echo"<td align='left'>";
							if($ENABLE_MANAGE){	?>
                            <a href="#" onClick="window.open('<?php echo site_url();?>assets/files/<?php echo "$datas->nama_file"; ?>', '_blank')"  class="btn btn-sm btn-success" title="View Data"><i class="fa fa-eye"></i><a/>							
							
							<?php
							echo"<a href='".site_url('folders/download_detail2/'.$datas->id)."' class='btn btn-sm btn-primary' title='Download Data' data-role='qtip'><i class='fa fa-download'></i></a>";
							
							echo"<a href='".site_url('folders/edit_detail2/'.$datas->id)."' class='btn btn-sm btn-warning' title='Edit Data' data-role='qtip'><i class='fa fa-pencil'></i></a>";
							}
							if($ENABLE_DELETE){ 
                          	echo"&nbsp;<a href='".site_url('folders/delete_detail2/'.$datas->id)."' class='btn btn-sm btn-danger' title='Delete Data' data-role='qtip'><i class='fa fa-trash'></i></a>";
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
</script>

