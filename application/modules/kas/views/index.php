<div class="card card-stretch shadow card-custom">
	<div class="card-header bg-white border-bottom-0 pt-3">
		<div class="d-flex justify-content-between">
			<h3 class="card-title"><?= $title; ?></h3>
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCash" id="new_cash"><i class="fa fa-plus"></i> Input Kas</button>
		</div>

		<label for="">Tanggal : <?= date('d F Y'); ?></label>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="datatable table table-condensed table-striped table-sm">
				<thead class="bg-light">
					<tr style="vertical-align: middle;">
						<th>No.</th>
						<th>No. Kas</th>
						<th>Tgl.</th>
						<th>No. Reff</th>
						<th>Tipe</th>
						<th>Kategori</th>
						<th>Metode</th>
						<th>Uang Masuk</th>
						<th>Uang Keluar</th>
						<th>Keterangan</th>
						<th>User</th>
					</tr>
				</thead>
				<tbody>
					<?php $n = 0;
					$type = [
						'IN' 	=> 'Masuk',
						'OUT' => 'Keluar'
					];
					$pengeluaran = 0;
					$pemasukan = 0;
					foreach ($data as $dt) : $n++;
						$pengeluaran += $dt->out_value;
						$pemasukan += $dt->in_value;
					?>
						<tr>
							<td class="small"><?= $n; ?></td>
							<td class="small"><?= $dt->id; ?></td>
							<td class="text-center small"><?= $dt->date; ?></td>
							<td class="text-center small"><a href="#">#<?= $dt->no_reff; ?></a></td>
							<td class="text-center small"><?= $type[$dt->type]; ?></td>
							<td class="text-center small"><?= $dt->category_name; ?></td>
							<td class="text-center small"><?= $dt->name; ?></td>
							<td class="text-end small"><?= number_format($dt->in_value); ?></td>
							<td class="text-end small"><?= number_format($dt->out_value); ?></td>
							<td class="small"><?= $dt->description; ?></td>
							<td class="small"><?= ucfirst($dt->username); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="text-end small" colspan="7">
							<h5>Subtotal</h5>
						</th>
						<th class="text-end table-success small">
							Rp. <?= ($pemasukan) ? number_format($pemasukan) : 0; ?>,-
						</th>
						<th class="text-end table-danger small">
							Rp. <?= ($pengeluaran) ? number_format($pengeluaran) : 0; ?>,-
						</th>
					</tr>
					<tr>
						<th colspan="7" class="text-end small">
							<h5>Total</h5>
						</th>
						<th colspan="2" class="table-primary small text-end">
							Rp. <span id="gTotal"><?= (abs($pemasukan) - abs($pengeluaran)) ? number_format(abs($pemasukan) - abs($pengeluaran)) : 0; ?></span>,-
						</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="card-body text-center">
		<!-- <button type="button" id="close_book" data-user="<?= $this->session->User['id_user']; ?>" class="btn btn-warning btn-lg"><i class="fa fa-book"></i> Tutup Buku</button> -->
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tutup Buku</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form id="form-tgl-closing">
						<h4 for="">Data Transaksi</h4>
						<hr>
						<div class="mb-3 d-flex justify-content-between">
							<label for="sDate" class="form-label text-bolder">Tgl. Tutup Buku</label>
							<h4 class="text-danger" id="cDate"></h4>
						</div>
						<div class="mb-3 d-flex justify-content-between">
							<label for="sDate" class="form-label text-bolder">Total Pemasukan</label>
							<h4 class="text-success" id="tPemasukan">0,-</h4>
						</div>
						<div class="mb-3 d-flex justify-content-between">
							<label for="eDate" class="form-label text-bolder">Total Pengeluaran</label>
							<h4 class="text-danger" id="tPengeluaran">0,-</h4>
						</div>
						<hr>

						<div class="mb-3 d-flex justify-content-between">
							<label for="eDate" class="form-label">Grand Total</label>
							<h4 class="text-primary" id="tGrandTotal">0,-</h4>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="process_close" class="btn btn-success"><i class="fa fa-book"></i> Proses Tutup Buku</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCash" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Input Keuangan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-cash-input">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="" class="form-label">Tgl. Transaksi</label>
								<input type="date" class="form-control" name="date" id="date" value="<?= date('Y-m-d'); ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="" class="form-label">No. Reff</label>
								<input type="text" class="form-control" name="no_reff" id="no_reff" placeholder="Nomor Referensi">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="" class="form-label">Tipe Kas</label>
								<select name="type" id="type" class="form-control">
									<option value=""></option>
									<option value="IN">Uang Masuk</option>
									<option value="OUT">Uang Keluar</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="" class="form-label">Kategori</label>
								<select class="form-select" name="category" id="category" aria-label="Default select example">
									<option value=""></option>
									<?php foreach ($cat as $category) : ?>
										<option value="<?= $category->id; ?>"><?= $category->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="" class="form-label">Metode</label>
								<br>
								<?php foreach ($methode as $mtd) : ?>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="payment_methode" id="radio_<?= $mtd->id; ?>" value="<?= $mtd->id; ?>">
										<label class="form-check-label" for="radio_<?= $mtd->id; ?>"><?= $mtd->name; ?></label>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="" class="form-label">Jml. Uang</label>
								<input type="text" name="cash_value" id="cash_value" placeholder="0" class="form-control text-end numeric currency">
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label for="" class="form-label">Keterangan</label>
						<textarea name="description" id="description" rows="5" class="form-control" placeholder="Keterangan"></textarea>
					</div>
				</div>
			</form>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="save_cash"><i class="fa fa-save"></i> Save</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="close-by-date" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tutup Buku</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form id="form-tgl-closing">
						<h4 for="">Pilih Tanggal</h4>
						<div class="mb-3">
							<label for="date_close" class="form-label text-bolder">Tgl. Tutup Buku</label>
							<input type="date" name="date_close" class="form-control form-control-sm" id="date_close" aria-describedby="textHelp" value="<?= date('Y-m-d'); ?>">
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="close_by_date" class="btn btn-success">Selanjutnya <i class="fa fa-arrow-right"></i></button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		$('.datatable').DataTable();
	})

	$(document).on('click', '#close_book', function() {
		let gTotal = $('#gTotal').text().replace(/[\.,]/g, '') || 0;
		// console.log($('#gTotal').text().replace(/[\.,]/g, '') || 0);
		if (gTotal === 0) {
			Swal.fire({
				title: 'Informasi',
				text: 'Tidak ada data transaksi dilakukan.',
				icon: 'info',
			})
			return false;
		} else {
			cek_close()
		}
	})

	function cek_close() {
		let today = new Date();
		let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
		$.ajax({
			url: siteurl + controller + 'check_closing',
			data: {
				date
			},
			type: 'POST',
			dataType: 'JSON',
			success: function(result) {
				if (result.status == 0) {
					Swal.fire({
						title: 'Konfirmasi',
						text: result.msg,
						icon: 'question',
						showCancelButton: true,
						showDenyButton: true,
						confirmButtonText: 'Tentukan Tanggal',
						denyButtonText: 'Tutup semua hari ini',
						allowOutsideClick: false,
					}).then((value) => {
						console.log(value)
						if (value.isConfirmed) {
							$('#close-by-date').modal('show');
						} else if (value.isDenied) {
							// closing(date)
						}
					})
					return false;
				} else {
					check_close_date(date)
				}
			},
			error: function(result) {
				Swal.fire({
					title: 'Error!',
					text: 'Server Timeout',
					icon: 'error',
					timer: 3000
				});
				return false;
			}
		})
		return false;
	}

	function check_close_date(date) {

		if (date) {
			$.ajax({
				url: siteurl + controller + 'close_by_date',
				dataType: 'JSON',
				data: {
					date
				},
				type: 'POST',
				success: function(result) {
					gTotal = parseFloat(result.data.in_value || 0) - parseFloat(result.data.out_value || 0)
					$('#tPemasukan').text(new Intl.NumberFormat().format(result.data.in_value))
					$('#tPengeluaran').text(new Intl.NumberFormat().format(result.data.out_value))
					$('#tGrandTotal').text(new Intl.NumberFormat().format(gTotal))
					$('#cDate').text(date)

					$('#modelId').modal('show')
					$('#close-by-date').modal('hide')
				},
				error: function(result) {
					Swal.fire({
						title: 'Error!',
						text: 'Server Timeout',
						icon: 'error',
						timer: 3000
					});
					return false;
				}
			})
		}
	}
	$(document).on('click', '#close_by_date', function() {
		let date = $('#date_close').val();
		check_close_date(date)
	});

	$(document).on('click', '#process_close', function() {
		let date = $('#cDate').text()
		closing(date)
	})

	function closing(date = "") {
		Swal.fire({
			title: 'Konfirmasi!',
			text: 'Apakah sudah yakin ingin menutup buku?',
			icon: 'question',
			showCancelButton: true,
			timerProgressBar: true,
			allowOutsideClick: false,
			showLoaderOnConfirm: true,
			preConfirm: () => {
				return $.ajax({
					url: siteurl + controller + 'closing_book',
					type: 'POST',
					dataType: 'JSON',
					data: {
						date
					},
					success: function(result) {
						if (result.status == 1) {
							Swal.fire({
								title: 'Proses Berhasil!',
								text: result.msg,
								icon: 'success',
								timer: 3000,
							}).then(function() {
								location.reload()
							})
						} else {
							Swal.fire({
								title: 'Proses Gagal!',
								text: result.msg,
								icon: 'warning',
								timer: 3000,
							})
						}
					},
					error: function(result) {
						Swal.fire({
							title: 'Error!',
							text: 'Server timeout!',
							timer: 3000,
							icon: 'error'
						})
					}
				})
			}
		}).then((value) => {
			if (value.isConfirmed) {
				console.log(value.value);
			}
		})
	}

	$(document).on('click', '#save_cash', function() {

		if (!$('#date').val()) {
			Swal.fire({
				title: 'Peringatan',
				text: 'Tanggal belum di isi. Mohon mengisi tanggal terlebih dahulu',
				icon: 'warning',
				timer: 3000
			});
			return false;
		} else if (!$('#type').val()) {
			Swal.fire({
				title: 'Peringatan',
				text: 'Tipe Kas belum dipilih. Mohon memilih tipe kas terlebih dahulu',
				icon: 'warning',
				timer: 3000
			});
			return false;
		} else if (!$('#category').val()) {
			Swal.fire({
				title: 'Peringatan',
				text: 'Kategori Kas belum dipilih. Mohon memilih kategori kas terlebih dahulu',
				icon: 'warning',
				timer: 3000
			});
			return false;
		} else if ($('input[name="payment_methode"]:checked').length == 0) {
			Swal.fire({
				title: 'Peringatan',
				text: 'Metode p	embayaran Kas belum dipilih. Mohon memilih Metode pembayaran kas terlebih dahulu',
				icon: 'warning',
				timer: 3000
			});
			return false;
		} else if (!$('#cash_value').val()) {
			Swal.fire({
				title: 'Peringatan',
				text: 'Jumlah Uang Kas belum diisi. Mohon pengisi Jumlah Uang kas terlebih dahulu',
				icon: 'warning',
				timer: 3000
			});
			return false;
		} else {
			let formdata = new FormData($('#form-cash-input')[0]);
			Swal.fire({
				title: 'Konfirmasi!',
				text: 'Apakah sudah yakin data yang diinput sudah benar?',
				icon: 'question',
				showCancelButton: true,
				timerProgressBar: true,
				allowOutsideClick: false,
				showLoaderOnConfirm: true,
				preConfirm: () => {
					return $.ajax({
						url: siteurl + controller + 'save_cash',
						data: formdata,
						dataType: 'JSON',
						type: 'POST',
						contentType: false,
						processData: false,
						async: false,
						success: function(result) {
							if (result.status == 1) {
								Swal.fire({
									title: 'Proses Berhasil!',
									text: result.msg,
									icon: 'success',
									timer: 3000,
								}).then(function() {
									location.reload()
								})
							} else {
								Swal.fire({
									title: 'Proses Gagal!',
									text: result.msg,
									icon: 'warning',
									timer: 3000,
								})
							}
						},
						error: function(result) {
							Swal.fire({
								title: 'Proses Gagal!',
								text: 'Data tidak valid',
								icon: 'error',
								timer: 3000,
							})
						}
					})
				}

			}).then((value) => {
				if (value.isConfirmed) {
					console.log(value.value);
				}
			})
		}
	})
</script>