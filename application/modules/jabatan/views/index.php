<?php
$ENABLE_ADD     = has_permission('Jabatan.Add');
$ENABLE_MANAGE  = has_permission('Jabatan.Manage');
$ENABLE_VIEW    = has_permission('Jabatan.View');
$ENABLE_DELETE  = has_permission('Jabatan.Delete');
$ENABLE_DOWNLOAD  = has_permission('Jabatan.Download');
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?= $title; ?></h3>
		<div class="box-tool pull-right">
			<?php
			if ($ENABLE_ADD) {
			?>
				<a href="<?php echo site_url('jabatan/add') ?>" class="btn btn-sm btn-success" id='btn-add'>
					<i class="fa fa-plus"></i> Add Jabatan
				</a>
			<?php
			}
			?>
		</div>
	</div>
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead style="color:white">
				<tr>
					<th width="20px">No</th>
					<th>Jabatan</th>
					<th>User</th>
					<th align="center" width="100px">Option</th>

				</tr>
			</thead>
			<tbody>
				<?php
				if ($row) :
					$int	= 0;
					foreach ($row as $datas) :
						$int++;
				?>
						<tr>
							<td><?= $int; ?></td>
							<td><?= $datas->nm_jabatan; ?></td>
							<td>
								<?php
								$Pejabat = $this->db->get_where('view_user_pejabat', ['id' => $datas->id, 'id_perusahaan' => $prsh])->result();
								$n = 0;
								foreach ($Pejabat as $pej) : $n++ ?>
									<span><?= $n . ". " . $pej->nm_lengkap; ?></span><br>
								<?php endforeach; ?>
							</td>
							<td <td align='center'>
								<?php
								if ($ENABLE_VIEW) {
									echo "<a href='" . site_url('jabatan/add_pejabat?id_jabatan=' . $datas->id) . "' class='btn btn-sm btn-primary' title='Tambah Pejabat' data-role='qtip'><i class='fa fa-user'></i></a>";
								}; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<script>
	$('#example1').DataTable({
		orderCellsTop: false,
		fixedHeader: true,
		scrollX: true,
		ordering: false,
		info: false
	});

	$(document).ready(function() {
		$('#btn-add').click(function() {
			loading_spinner();
		});

	});

	function delData(id) {
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
					window.location.href = base_url + 'index.php/' + active_controller + '/delete/' + id;

				} else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				}
			});

	}
</script>