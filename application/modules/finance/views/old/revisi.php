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
 <form id="form-subsubject" method="post">
<div class="nav-tabs-salesorder">
     <div class="tab-content">
        <div class="tab-pane active" id="salesorder">			
            <div class="box box-success">
               	<?php //print_r($kode_customer)?>
				<div class="box-body">
				<h3>History Revisi</h3>
			<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th width="10">No Rev</th>
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
                <div class="box-body">
				<h3>Create Approval</h3>
                    <div class="col-sm-6 form-horizontal">
					    <div class="row">
                            <div class="row ">
                            <label for="nm_subsubject" class="col-sm-4 control-label">Status Action Plan :</label>
							 </div>
                            <div class="row">
							   <input type="hidden" id="id" name="id" value="<?=(isset($id)?$id:'0')?>" />
							   <input type="hidden" id="table" name="table" value="<?=(isset($table)?$table:'-')?>" />
							   <input type="hidden" id="uri1" name="uri1" value="<?php echo $uri3 ?>" />
							   <input type="hidden" id="uri2" name="uri2" value="<?php echo $uri4 ?>" />
							   <input type="hidden" id="uri3" name="uri3" value="<?php echo $uri5 ?>" />
							   <input type="hidden" id="uri4" name="uri4" value="<?php echo $uri6 ?>" />
							   
                                <select class="form-control input-sm select2" name="status" id="status">
									<option value="approve">Approve</option>
                                    <option value="revisi">Revisi</option>									
								 </select> 
                            </div>
							
                         	
                          <div class="row">
                            <label for="deskripsi" class="col-sm-4 control-label">Keterangan </font></label>
                           
                          </div>
						   <div  class="row">
                              <textarea name="keterangan" class="form-control input-sm" id="keterangan" height=50></textarea>            							  
                            </div>
                        
	                						  
                        </div>
						
                       
            </div>
		</div>
	</div>
   </div>
</div>
</form>

<div class="text-center">
  <div class="box active"> 
    <div class="box-body">
        <button class="btn btn-success" type="button" onclick="saveapproval()"> 
            <i class="fa fa-save"></i><b> Simpan</b>
        </button>
    </div>
  </div>
</div>


 <script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
 <script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
  <script src="<?= base_url('assets/js/jquery.maskMoney.js')?>"></script>
 <script>
 
	function saveapproval(){
		  var uri1      = $('#uri1').val();
		  var uri2      = $('#uri2').val();
		  var uri3      = $('#uri3').val();
		  var uri4      = $('#uri4').val();
     
         
	    if ($('#status').val() == "") {
          swal({
            title	: "STATUS TIDAK BOLEH KOSONG!",
            text	: "ISI STATUS TERLEBIH DAHULU!",
            type	: "warning",
            timer	: 500,
            showCancelButton	: false,
            showConfirmButton	: false,
            allowOutsideClick	: false
          });
        }
		else {		
        swal({
          title: "Peringatan !",
          text: "Pastikan data sudah lengkap dan benar",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, simpan!",
          cancelButtonText: "Batal!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm){
			if(isConfirm) {
				var formdata = $("#form-subsubject").serialize();
				$.ajax({
					url: siteurl+"dokumen/saveApproval",
					dataType : "json",
					type: 'POST',
					data: formdata,
					success: function(data){
						if(data.status == 1){
						swal({
						  title	: "Save Success!",
						  text	: data.pesan,
						  type	: "success",
						  timer	: 15000,
						  showCancelButton	: false,
						  showConfirmButton	: false,
						  allowOutsideClick	: false
						});
						window.location.href =  siteurl + active_controller+'/'+uri2+'/'+uri3+'/'+uri4;
					  }else{

						if(data.status == 2){
						  swal({
							title	: "Save Failed!",
							text	: data.pesan,
							type	: "warning",
							timer	: 10000,
							showCancelButton	: false,
							showConfirmButton	: false,
							allowOutsideClick	: false
						  });
						}else{
						  swal({
							title	: "Save Failed!",
							text	: data.pesan,
							type	: "warning",
							timer	: 10000,
							showCancelButton	: false,
							showConfirmButton	: false,
							allowOutsideClick	: false
						  });
						}

					  }
					},
					error: function(){
						swal({
							title: "Gagal!",
							text: "Batal Proses, Data bisa diproses nanti",
							type: "error",
							timer: 1500,
							showConfirmButton: false
						});
					}
				});
			}
        });		
		}    
    }
	
	
	

</script>
	</td>
	<td><iframe src='<?php echo site_url();?>assets/files/<?php echo "$nama_file"; ?>' width='100%' height='565px' frameborder='0'> </iframe></td>
</tr>
</table>
 </body>
</html>