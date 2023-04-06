<form action="#" method="POST" id="form_proses_bro">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">
				<?= $title;
				if ($row) {
					foreach ($row as $datas) {
						$id_jabatan = $datas->id;
						$jabatan = $datas->nm_jabatan;
					}
				}
				?>
			</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Nama Jabatan<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<input type="hidden" id="id_jabatan" name="id_jabatan" name="id_jabatan" value="<?= $id_jabatan ?>">
						<input type="text" id="nm_jabatan" name="nm_jabatan" name="nm_jabatan" value="<?= $jabatan ?>" class="form-control" readonly>
						<!--<a href="#" class="btn btn-sm btn-success plus" title="Add Pejabat" id='add-pejabat'>
						<i class="fa fa-user"></i> </a>-->
					</div>
				</div>
				<label class='label-control col-sm-2'><b>Nama Karyawan<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<select name="user" id="user" class="form-control input-md select2">";
							<option value="0">Pilih User</option><?= $results['users'] ?>
						</select>
					</div>


				</div>
			</div>
		</div>
		<div class='box-footer'>
			<?php
			echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-primary', 'value' => 'save', 'content' => 'Save', 'id' => 'simpan-com')) . ' ';
			echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-danger', 'value' => 'back', 'content' => 'Back', 'onClick' => 'javascript:kembali()'));
			?>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</form>

<form id='form-update' method='post'>
	<div class="box box-success">
		<div class="box-header">
			<h3 class="box-title">List</h3>
		</div>
		<div class="box-body">
			<div id="data">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="20px">No.</th>
							<th>Nama Karyawan</th>
							<th width="100px">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$n = 0;
						foreach ($pejabat as $pjb) : $n++ ?>
							<tr>
								<td><?= $n; ?></td>
								<td><?= $pjb->nm_lengkap; ?></td>
								<td>
									<button type="button" data-usr="<?= $pjb->id_user; ?>" data-id="<?= $pjb->id; ?>" data-prsh="<?= $pjb->id_perusahaan; ?>" data-cbg="<?= $pjb->id_cabang; ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</form>

<script>
	$(document).ready(function() {
		$('.select2').select2();
		// DataDetail();

		$('#simpan-com').click(function(e) {
			e.preventDefault();
			var nama_master = $('#nm_jabatan').val();
			if (nama_master == '' || nama_master == null) {
				swal({
					title: "Error Message!",
					text: 'Empty Nama Jabatan, please input Nama Jabatan  first.....',
					type: "warning"
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
						var formData = new FormData($('#form_proses_bro')[0]);
						var baseurl = base_url + active_controller + '/savePejabat';
						$.ajax({
							url: baseurl,
							type: "POST",
							data: formData,
							cache: false,
							dataType: 'json',
							processData: false,
							contentType: false,
							success: function(data) {
								if (data.status == 1) {
									swal({
										title: "Save Success!",
										text: data.pesan,
										type: "success",
										timer: 7000,
										showCancelButton: false,
										showConfirmButton: false,
										allowOutsideClick: false
									});
									//window.location.href = base_url + active_controller;
									DataDetail();

								} else {

									if (data.status == 2) {
										swal({
											title: "Save Failed!",
											text: data.pesan,
											type: "warning",
											timer: 7000,
											showCancelButton: false,
											showConfirmButton: false,
											allowOutsideClick: false
										});
									} else {
										swal({
											title: "Save Failed!",
											text: data.pesan,
											type: "warning",
											timer: 7000,
											showCancelButton: false,
											showConfirmButton: false,
											allowOutsideClick: false
										});
									}

								}
							},
							error: function() {

								swal({
									title: "Error Message !",
									text: 'An Error Occured During Process. Please try again..',
									type: "warning",
									timer: 7000,
									showCancelButton: false,
									showConfirmButton: false,
									allowOutsideClick: false
								});
							}
						});
					} else {
						swal("Cancelled", "Data can be process again :)", "error");
						return false;
					}
				});
		});

		$(document).on('click', '.delete', function() {
			let id = $(this).data('id')
			let usr = $(this).data('usr')
			let prsh = $(this).data('prsh')
			let cbg = $(this).data('cbg')
			// alert(id + ", " + usr + ", " + prsh + ", " + cbg);
			swal({
					title: 'Perhatian!!',
					text: 'Anda yakin akan menghapus data ini?',
					showCancelButton: true,
					showConfirmButton: true
				},
				function(value) {
					if (value == true) {
						$.ajax({
							url: siteurl + active_controller + 'delete_user',
							data: {
								id,
								usr,
								prsh,
								cbg
							},
							type: 'POST',
							dataType: 'JSON',
							success: function(result) {
								if (result.status == 0) {
									swal({
										title: 'Gagal!!',
										text: result.pesan,
										type: 'error'
									})
								} else {
									swal({
										title: 'Success',
										text: result.pesan,
										type: 'success'
									}, function() {
										location.reload()
									})
								}
							},
							error: function(result) {
								swal({
									title: 'Error',
									text: 'Internal server error',
									type: 'error'
								})
							}
						})
					}
				});

		})
	});



	function DataDetail() {

		var cari = $("#id_jabatan").val();

		$.ajax({
			type: "POST",
			url: siteurl + "jabatan/load_pejabat",
			data: "cari=" + cari,
			success: function(data) {
				$("#data").html(data);
				$("#loading").fadeOut(100);
				$("#data").fadeIn(500);
				$('.select2').select2();
				$('.tanggal').datepicker({
					format: 'dd-M-yyyy',
					startDate: '0',
					autoclose: true,
					todayHighlight: true
				});

			}
		});
	}

	function kembali() {
		window.location.href = base_url + active_controller;
	}
</script>