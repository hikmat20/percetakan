<div class="d-flex justify-content-between align-items-center mb-3">
	<h3 class="label"><?= $title; ?></h3>
</div>
<div class="card">
	<div class="card-header">
		<div class="row">
			<label class="col-md-1">Bulan</label>
			<div class="col-md-2">

				<select name="" id="month" class="form-select select" data-width="300px" data-allow-clear="true" data-placeholder="~ Pilih Bulan ~">
					<option value="">~ Pilih Bulan ~ </option>
					<?php foreach ($avl_month as $key => $mnt) : ?>
						<option value="<?= $mnt->date; ?>"><?= $month[sprintf("%02d", $mnt->date)]; ?></option>
					<?php endforeach; ?>
				</select>

			</div>
			<div class="col-md-9">
				<button class="btn btn-md btn-outline-primary float-end" type="button"><i class="fa fa-file-text"></i> PDF</button>
				<a class="btn btn-primary float-end me-2" href="<?= base_url('salary/add_new_salary'); ?>" title="Input Gaji Karyawan"><i data-feather="plus" class="me-1">&nbsp;</i>Input Gaji Karyawan</a>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-reponsive">
			<table id="example1" class="table table-sm table-striped">
				<thead>
					<tr class="table-light">
						<th width="50">No</th>
						<th>Nama Karyawan</th>
						<th>Bulan</th>
						<th>Masuk</th>
						<th>Libur</th>
						<th>Potong Libur</th>
						<th>Gaji</th>
						<th>Harian</th>
						<th>Potong Bon</th>
						<th>Gaji Diterima</th>
						<th width="">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $n = 0;
					foreach ($data as $dt) : $n++; ?>
						<tr>
							<td><?= $n; ?></td>
							<td><?= $dt->employee_name; ?></td>
							<td><?= $dt->month_name; ?></td>
							<td class="text-end"><?= ($dt->work_days); ?> hari</td>
							<td class="text-end"><?= ($dt->actual_leave); ?> hari</td>
							<td class="text-end"><?= ($dt->not_pay_day); ?> hari</td>
							<td class="text-end"><?= number_format($dt->monthly_salary); ?></td>
							<td class="text-end"><?= number_format($dt->dayli_salary); ?></td>
							<td class="text-end"><?= number_format($dt->pay_debt); ?></td>
							<td class="text-end"><?= number_format($dt->take_home_pay); ?></td>
							<td class="text-center">
								<div class="dropdown">
									<button class="btn btn-warning btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-cog"></i>
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<button type="button" title="Rincian Gaji" data-id="<?= $dt->id; ?>" class="detail dropdown-item btn btn-sm btn-light-info text-info"><i class="fa fa-eye"></i> Rincian</button>
										<?php if ($dt->status == 'OPN') : ?>
											<a href="<?= base_url('salary/edit/') . $dt->id; ?>" target="_blank" title="Print Selip Gaji" class="dropdown-item btn btn-sm btn-light-warning text-warning"><i class="fa fa-edit"></i> Ubah</a>
										<?php endif; ?>
										<a href="<?= base_url('salary/salary_detail/') . $dt->id; ?>" target="_blank" title="Print Selip Gaji" class="dropdown-item btn btn-sm btn-light-success text-success"><i class="fa fa-file-text-o"></i> Slip Gaji</a>
										<?php if ($dt->status == 'OPN') : ?>
											<hr class="my-0">
											<button type="button" title="Sudah Diterima" data-id="<?= $dt->id; ?>" class="dropdown-item btn btn-sm btn-light-danger text-default receive_salary"><i class="fa fa-check"></i> Sudah Diterima</button>
											<hr class="my-0">
											<button type="button" title="Hapus Gaji" class="dropdown-item btn btn-sm btn-light-danger text-danger"><i class="fa fa-trash"></i> Hapus</button>
										<?php endif; ?>
									</div>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- /.box-body -->
</div>

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Rincian Gaji</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="dataView">
				Body
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>


<!-- page script -->
<script type="text/javascript">
	$(document).ready(function() {
		$("#example1").DataTable();
		$("#form-area").hide();
		// 	$('.select2').select2()
		$(document).on('click', '.detail', function() {
			let id = $(this).data('id')
			// alert()
			let dataUrl = siteurl + controller + 'detail/' + id
			$('#modelId').modal('show')
			$('#dataView').load(dataUrl)
			// $.ajax({
			// 	url: siteurl + controller + '/detail/' + id,
			// 	type: 'POST',
			// 	success: function(result) {
			// 	},
			// 	error: function(result) {
			// 		swal({
			// 			title: "Error!",
			// 			text: "Internal Error!",
			// 			type: "error",
			// 		});
			// 	}
			// })
		})

		$(document).on('change', '#month', function() {
			const month = $(this).val()
			if (month) {
				$('table tbody').load(siteurl + controller + 'loadData/' + month)
				$("#example1").DataTable();
			}
		})
	})

	$(document).on('click', '.receive_salary', function() {
		const id = $(this).data('id')
		if (id) {
			Swal.fire({
				title: "Anda Yakin?",
				text: "Gaji sudah diterima!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya!",
				cancelButtonText: "Tidak!",
				closeOnConfirm: false,
				closeOnCancel: true
			}).then((value) => {
				console.log(value.isConfirmed);
				if (value.isConfirmed) {
					$.ajax({
						url: siteurl + controller + 'receive_salary',
						dataType: "json",
						type: 'POST',
						data: {
							id
						},
						success: function(msg) {
							if (msg.status == '1') {
								Swal.fire({
									title: "Berhasil!",
									text: "Gaji Sudah diterima",
									icon: "success",
									timer: 1500,
								}).then(() => {
									window.location.reload();
								})
							} else {
								Swal.fire({
									title: "Gagal!",
									text: "Gaji gagal diterima",
									icon: "error",
									timer: 1500,
								});
							};
						},
						error: function() {
							Swal.fire({
								title: "Error!",
								text: "Server Timeout. Terjadi kesalahan!",
								icon: "error",
								timer: 1500,
							});
						}
					});
				} else {
					//cancel();
				}
			});
		}
	})

	function add_data() {
		var url = 'perusahaan/create/';
		$(".box").hide();
		$("#form-area").show();
		$("#form-area").load(siteurl + url);
		$("#title").focus();
	}

	function edit_data(id) {
		if (id != "") {
			var url = 'cabang/edit/' + id;
			$(".box").hide();
			$("#form-area").show();
			$("#form-area").load(siteurl + url);
			$("#title").focus();
		}
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
						url: siteurl + 'perusahaan/hapus_perusahaan/' + id,
						dataType: "json",
						type: 'POST',
						success: function(msg) {
							if (msg['delete'] == '1') {
								swal({
									title: "Terhapus!",
									text: "Data berhasil dihapus",
									type: "success",
									timer: 1500,
									showConfirmButton: false
								});
								window.location.reload();
							} else {
								swal({
									title: "Gagal!",
									text: "Data gagal dihapus",
									type: "error",
									timer: 1500,
									showConfirmButton: false
								});
							};
						},
						error: function() {
							swal({
								title: "Gagal!",
								text: "Gagal Eksekusi Ajax",
								type: "error",
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

	function PreviewPdf(id) {
		param = id;
		tujuan = 'customer/print_request/' + param;

		$(".modal-body").html('<iframe src="' + tujuan + '" frameborder="no" width="570" height="400"></iframe>');
	}

	$(document).on('click', '#create', function() {

		var id_customer = 0;

		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Add Perusahaan</b>");
		$.ajax({
			type: 'POST',
			url: siteurl + 'perusahaan/create/',
			data: {
				'id_customer': id_customer
			},
			success: function(data) {
				$("#dialog-data-lebihbayar").modal();
				$("#MyModalBodyLebihbayar").html(data);

			}
		})
	});

	$(document).on('click', '#edit', function() {

		var id_perusahaan = $(this).data('perusahaan');

		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Perusahaan</b>");
		$.ajax({
			type: 'POST',
			url: siteurl + 'perusahaan/edit/',
			data: {
				'id_perusahaan': id_perusahaan
			},
			success: function(data) {
				$("#dialog-data-lebihbayar").modal();
				$("#MyModalBodyLebihbayar").html(data);

			}
		})
	});
</script>