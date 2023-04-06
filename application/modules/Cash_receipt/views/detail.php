<div class="card">
	<div class="card-body">
		<table class="table table-responsive-sm table-sm table-borderless">
			<tbody>
				<tr>
					<td width="20%">Karyawan</td>
					<td class="fw-bold text-secondary">: <?= $employee->employee_name; ?></td>
				</tr>
				<tr>
					<td width="20%">Bagian</td>
					<td class="fw-bold text-secondary">: <?= $position_name; ?></td>
				</tr>

			</tbody>
		</table>
		<hr>
		<div class="row">

			<!-- Data Kasbon -->
			<div class="col-md-6">
				<p class="fw-bold text-danger"><i class="fa fa-history"></i> Riwayat Kasbon</p>
				<table class="datatable table table-sm table-">
					<thead class="table-light">
						<tr>
							<th width="20px">No</th>
							<th>Tanggal</th>
							<th>Keperluan</th>
							<th width="180" class="text-end">Jumlah Kasbon</th>
							<th width="150" class="text-center">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($dataKasbon) :
							$n = 0;
							foreach ($dataKasbon as $dt) : $n++ ?>
								<tr>
									<td><?= $n; ?></td>
									<td><?= $dt->date; ?></td>
									<td><?= $dt->description; ?></td>
									<td class="text-end"><?= number_format($dt->cash_value); ?></td>
									<td class="text-center">
										<button type="button" class="btn btn-warning btn-xs btn-icon edit_pay_debt" data-id="<?= $dt->id; ?>" title="Ubah Kasbon"><i class="fa fa-edit"></i></button>
										<button type="button" class="btn btn-danger btn-xs btn-icon delete_debt" data-id="<?= $dt->id; ?>" title="Hapus Kasbon"><i class="fa fa-trash"></i></button>
									</td>
								</tr>
						<?php endforeach;
						endif; ?>
					</tbody>
					<tfoot class="table-light">
						<tr>
							<th colspan="3" class="text-end">Total</th>
							<th class="text-end"><?= ($cashReceipt) ? number_format($cashReceipt->cash_value) : '0'; ?></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>

			<!-- Data Pembayaran Kasbon -->
			<div class="col-md-6">
				<p class="fw-bold text-success"><i class="fa fa-history"></i> Riwayat Bayar Kasbon</p>
				<table class="datatable table table-sm table-bordered">
					<thead class="table-light">
						<tr>
							<th width="20px">No</th>
							<th>Tanggal</th>
							<th width="180" class="text-end">Jumlah Bayar</th>
							<th width="150" class="text-center">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<?php $n = 0;
						if ($payment) :
							foreach ($payment as $pay) : $n++ ?>
								<tr>
									<td><?= $n; ?></td>
									<td><?= $pay->date; ?></td>
									<td class="text-end"><?= (isset($pay->payment_value)) ? number_format($pay->payment_value) : ''; ?></td>
									<td class="text-center">
										<button type="button" class="btn btn-warning btn-xs btn-icon" title="Ubah Pembayaran"><i class="fa fa-edit"></i></button>
										<button type="button" data-id="<?= $pay->id; ?>" data-emp_id="<?= $pay->employee_id; ?>" class="btn btn-danger btn-xs btn-icon del_payment" title="Hapus Pembayaran"><i class="fa fa-trash"></i></button>
									</td>
								</tr>
						<?php endforeach;
						endif; ?>
					</tbody>
					<tfoot class="table-light">
						<tr>
							<th colspan="2" class="text-end">Total</th>
							<th class="text-end"><?= (isset($cashReceipt)) ? number_format($cashReceipt->total_payment) : '0'; ?></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<div class="d-flex justify-content-between">
					<div class="">
						<a href="<?= base_url('cash_receipt'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Kembali</a>
					</div>
					<div class="justify-content-between">
						<label>Total Kasbon</label>
						<h3 class="card-text fw-bold  text-danger">Rp. <?= ($cashReceipt) ? number_format($cashReceipt->sisa_kasbon) : '0'; ?></h3>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="d-flex justify-content-end align-content-center">
					<button type="button" class="btn btn-primary" id="paydebt" data-id="<?= ($cashReceipt) ? $cashReceipt->id : ''; ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fa fa-money"></i> Bayar Kasbon</button>
				</div>
			</div>
		</div>
	</div>
</div>

<form id="form-payment">
	<!-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button> -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
		<div class="offcanvas-header">
			<h4 id="offcanvasRightLabel" class="fw-bold">Bayar Kasbon</h4>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body" id="viewData">
			<div class="text-center">
				No available data
			</div>
		</div>
	</div>
</form>


<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="dataView">
				Body
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save</button> -->
			</div>
		</div>
	</div>
</div>



<script>
	$(document).ready(function() {
		$('.datatable').DataTable()


		$(document).on('click', '#paydebt', function() {
			let id = $(this).data('id');

			if (id) {
				$.ajax({
					url: siteurl + controller + 'payment_debt',
					type: 'POST',
					data: {
						id
					},
					success: function(result) {
						if (result) {
							$('#viewData').html(result)
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Error!",
							icon: 'error',
							text: result.msg,
							timer: 3000
						})
					}
				})
			}
		})

		$(document).on('click', '.edit_pay_debt', function() {
			let id = $(this).data('id')
			if (id) {
				$('#modelId').modal('show')
				$('#dataView').load(siteurl + controller + 'edit/' + id)
			}
		})

		$(document).on('click', '#savePaymentReceipt', function() {
			valid = true;
			let employee = $('#employee_id').val();
			let date = $('#date').val();
			let value = $('#payment_value').val();
			$('#employee_id').removeClass('is-invalid')
			$('#date').removeClass('is-invalid')
			$('#payment_value').removeClass('is-invalid')

			if (!employee) {
				$('#employee_id').addClass('is-invalid')
				valid = false;
				console.log('employee_id');
			}
			if (!date) {
				$('#date').addClass('is-invalid')
				valid = false;
				console.log('date');
			}
			if (!value) {
				$('#payment_value').addClass('is-invalid')
				valid = false;
				console.log('payment_value');
			}

			if (valid == true) {
				let formdata = new FormData($('#form-payment')[0])
				$.ajax({
					url: siteurl + controller + 'save_payment',
					type: 'POST',
					data: formdata,
					dataType: "JSON",
					contentType: false,
					processData: false,
					cache: false,
					success: function(result) {
						if (result.status == 1) {
							Swal.fire({
								title: 'Berhasil',
								text: result.msg,
								icon: 'success',
								timer: 3000
							}).then(() => {
								location.reload()
							})
						} else {
							Swal.fire({
								title: 'Gagal!',
								text: result.msg,
								icon: 'warning',
								timer: 3000
							})
						}
					},
					error: function(result) {
						Swal.fire({
							title: 'Error!',
							text: 'Error. Server timeout..',
							icon: 'error',
							timer: 3000
						})
					}
				})
			}
		})

		$(document).on('click', '.delete_debt', function() {
			let id = $(this).data('id')
			// let emp_id = $(this).data('emp_id')
			Swal.fire({
				title: "Anda Yakin?",
				text: "Data Kasbon akan dihapus?",
				icon: "question",
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
						url: siteurl + controller + 'delete_debt',
						type: 'POST',
						data: {
							id,
							// emp_id
						},
						dataType: "JSON",
						success: function(result) {
							if (result.status == 1) {
								Swal.fire({
									title: 'Berhasil',
									text: result.msg,
									icon: 'success',
									timer: 3000
								}).then(() => {
									location.reload()
								})
							} else {
								Swal.fire({
									title: 'Gagal!',
									text: result.msg,
									icon: 'warning',
									timer: 3000
								})
							}
						},
						error: function(result) {
							Swal.fire({
								title: 'Error!',
								text: 'Error. Server timeout..',
								icon: 'error',
								timer: 3000
							})
						}
					})
				}

			})
		})

		$(document).on('click', '.del_payment', function() {
			let id = $(this).data('id')
			let emp_id = $(this).data('emp_id')
			Swal.fire({
				title: "Anda Yakin?",
				text: "Pembayaran Kasbon akan dihapus?",
				icon: "question",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya!",
				cancelButtonText: "Tidak!",
				closeOnConfirm: false,
				closeOnCancel: true
			}).then((value) => {
				$.ajax({
					url: siteurl + controller + 'del_payment',
					type: 'POST',
					data: {
						id,
						emp_id
					},
					dataType: "JSON",
					success: function(result) {
						if (result.status == 1) {
							Swal.fire({
								title: 'Berhasil',
								text: result.msg,
								icon: 'success',
								timer: 3000
							}).then(() => {
								location.reload()
							})
						} else {
							Swal.fire({
								title: 'Gagal!',
								text: result.msg,
								icon: 'warning',
								timer: 3000
							})
						}
					},
					error: function(result) {
						Swal.fire({
							title: 'Error!',
							text: 'Error. Server timeout..',
							icon: 'error',
							timer: 3000
						})
					}
				})
			})
		})

	})
</script>