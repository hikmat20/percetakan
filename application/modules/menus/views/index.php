<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				<div class="d-flex justify-content-between">
					<h3 class="card-title"><?= $title; ?></h3>
					<button type="button" id="add" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
						<i class="fa fa-plus"></i> Tambah Menu
					</button>
				</div>
			</div>
		</div>

		<div class="mt-7 table-responsive">
			<table id="example1" class="table table-bordered table-striped table-sm table-hover">
				<thead class="table-secondary">
					<tr>
						<th width="50">#</th>
						<th>Nama Menu</th>
						<th>Link</th>
						<th width="125px" class="text-center">Status</th>
						<th width="25">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($results) :
						$numb = 0;
						foreach ($results as $record) :
							$numb++; ?>
							<tr>
								<td><?= $numb; ?></td>
								<td><?= $record->title ?></td>
								<td><?= $record->link ?></td>
								<td class="text-center"><?= $sts[$record->status]; ?></td>
								<td style="padding-left:20px">
									<a class="text-primary btn-sm btn btn-light-primary" href="javascript:void(0)" title="Edit" onclick="edit_data('<?= $record->id ?>')"><i class="fa fa-pencil"></i>
									</a>
									<a class="text-danger btn-sm btn btn-light-danger" href="javascript:void(0)" title="Delete" onclick="delete_data('<?= $record->id ?>')"><i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
					<?php endforeach;
					endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<th width="50">#</th>
						<th>Nama Menu</th>
						<th>Link</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="form-area">
					<?php $this->load->view('menus/menus_form') ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" name="save" class="btn btn-success" id="submit"><i data-feather="save"></i>&nbsp;Save</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	function edit_data(id) {
		if (id != "") {
			var url = 'menus/edit/' + id;
			$("#staticBackdrop").modal('show');
			$("#form-area").load(siteurl + url);
		}
	}

	function add() {

	}

	//Delete
	function delete_data(id) {
		//alert(id);
		Swal.fire({
				title: "Anda Yakin?",
				text: "Data Akan Terhapus secara Permanen!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya, delete!",
				cancelButtonText: "Tidak!",
				closeOnConfirm: false,
				closeOnCancel: true
			},
			function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						url: siteurl + 'menus/hapus_menus/' + id,
						dataType: "json",
						type: 'POST',
						success: function(msg) {
							if (msg['delete'] == '1') {
								Swal.fire({
									title: "Terhapus!",
									text: "Data berhasil dihapus",
									icon: "success",
									timer: 1500,
									showConfirmButton: false
								});
								window.location.reload();
							} else {
								Swal.fire({
									title: "Gagal!",
									text: "Data gagal dihapus",
									icon: "error",
									timer: 1500,
									showConfirmButton: false
								});
							};
						},
						error: function() {
							Swal.fire({
								title: "Gagal!",
								text: "Gagal Eksekusi Ajax",
								icon: "error",
								timer: 1500,
								showConfirmButton: false
							});
						}
					});
				} else {
					//cancel();
				}
			});
	}

	$(document).on('click', '#add', function() {
		var url = 'menus/create';
		$("#staticBackdrop").modal('show');
		$("#form-area").load(siteurl + url);
	})

	$(document).on('click', '#submit', function(e) {
		e.preventDefault();
		var formdata = $("#frm_menus").serialize();
		$.ajax({
			url: siteurl + "menus/save_data_menus",
			dataType: "json",
			type: 'POST',
			data: formdata,
			//alert(msg);
			success: function(msg) {
				if (msg['save'] == '1') {
					Swal.fire({
						title: "Sukses!",
						text: "Data Berhasil Di Simpan",
						icon: "success",
						timer: 1500,
						showConfirmButton: false
					});
					location.reload();
				} else {
					Swal.fire({
						title: "Gagal!",
						text: "Data Gagal Di Simpan",
						icon: "error",
						timer: 1500,
						showConfirmButton: false
					});
				}; //alert(msg);
			},
			error: function() {
				Swal.fire({
					title: "Gagal!",
					text: "Ajax Data Gagal Di Proses",
					icon: "error",
					timer: 1500,
					showConfirmButton: false
				});
			}
		});
	});

	function PreviewPdf(id) {
		param = id;
		tujuan = 'customer/print_request/' + param;

		$(".modal-body").html('<iframe src="' + tujuan + '" frameborder="no" width="570" height="400"></iframe>');
	}
</script>