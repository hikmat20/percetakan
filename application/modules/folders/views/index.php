<?php
$ENABLE_ADD     = has_permission('Folders.Add');
$ENABLE_MANAGE  = has_permission('Folders.Manage');
$ENABLE_VIEW    = has_permission('Folders.View');
$ENABLE_DELETE  = has_permission('Folders.Delete');
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?= $title; ?></h3>
		<div class="box-tool pull-right">
			<?php if ($ENABLE_ADD) : ?>
				<a href="<?php echo site_url('folders/add') ?>" class="btn btn-sm btn-success" id='btn-add'>
					<i class="fa fa-plus"></i> Add Folder
				</a>
			<?php endif; ?>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead style="color:white">
				<tr>
					<th>No</th>
					<th>Nama Folder</th>
					<th>Tanggal Pembuatan</th>
					<th align="center">Option</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($row) {
					$int	= 0;
					foreach ($row as $datas) {
						$int++;
						$tgl = date_create($datas->created);
						echo "<tr>";
						echo "<td>" . $datas->id_master . "</td>";
						echo "<td>" . $datas->nama_master . "</td>";
						echo "<td>" . date_format($tgl, "d-m-Y H:i:s") . "</td>";
						echo "<td align='center'>";
						if ($ENABLE_VIEW) {
							echo "<a href='" . site_url('folders/detail?id_master=' . $datas->id_master) . "' class='btn btn-sm btn-primary' title='Buka Folder' data-role='qtip'><i class='fa fa-folder-open'></i></a>";
						}
						if ($ENABLE_DELETE) {
							echo "&nbsp;<a href='" . site_url('folders/delete_master/' . $datas->id_master) . "' class='btn btn-sm btn-warning' title='Delete Data' data-role='qtip'><i class='fa fa-trash'></i></a>";
						}
						echo "</td>";
						echo "</tr>";
					}
				}
				?>
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
		orderCellsTop: true,
		fixedHeader: true,
		scrollX: true
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