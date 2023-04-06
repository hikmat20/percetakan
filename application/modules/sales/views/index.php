<div class="row">
	<div class="col-md-7">
		<div class="card mb-3" style="height:85vh;">
			<div class="card-header">
				<div class="row">
					<div class="col-md-8">
						<!-- Nav tabs -->
						<ul class="nav nav-pills" id="myTab" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" id="services-tab" data-bs-toggle="tab" data-bs-target="#services-list" type="button" role="tab" aria-controls="services" aria-selected="true">J A S A</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="stationery-tab" data-bs-toggle="tab" data-bs-target="#stationery-list" type="button" role="tab" aria-controls="stationery" aria-selected="false"> BARANG ATK</button>
							</li>
						</ul>
					</div>
					<div class="col-md-4 text-end">
						<div class="input-group input-group-sm">
							<button class="btn rounded-pill border-1" type="button"><i class="fa fa-search"></i></button>
							<input type="text" class="form-control float-end rounded-pill border-right-0 search" id="search" placeholder="Cari" />
						</div>
						<div class="form-group row">
						</div>
					</div>
				</div>
			</div>
			<div class="card-body overflow-auto">
				<div class="tab-content">
					<div class="tab-pane active" id="services-list" role="tabpanel" aria-labelledby="services-tab">
						<div class="row align-content-start" id="list-services">
							<?php foreach ($services as $svc) : ?>
								<div class=" col-md-2 col-lg-3 col-sm-3 col-xs-6 px-1 mb-2">
									<div class="card mb-3 shadow-md border-1 border py-2">
										<?php $img = ($svc->image) ? $svc->image : 'blank.png'; ?>
										<div class="img-responsive text-center" style="height:10rem">
											<img src="<?= base_url("assets/services/$img"); ?>" style="width:10rem;" class="card-img-top" alt="<?= $svc->name; ?>">
										</div>
										<div class="card-footer bg-white px-3 pt-3 pb-1 border-top-0 text-center">
											<!-- <h5 class="card-title text-center fw-bold"><?= $svc->name; ?></h5> -->
											<div class="d-grid">
												<button class="btn btn-light-primary btn-hover-primary fw-bold" data-bs-toggle="modal" data-bs-target="#ModalForm" id="choose-service" data-id="<?= $svc->id; ?>">
													<?= $svc->name; ?>
												</button>
											</div>
										</div>
									</div>
									<!-- <div class="d-grid">
								<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalForm" id="choose-service" data-id="<?= $svc->id; ?>" style="height:60px">
									<?= $svc->name; ?>
								</button>
							</div> -->
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="tab-pane" id="stationery-list" role="tabpanel" aria-labelledby="stationery-tab">
						<div class="row align-content-start" id="list-stationery">
							<?php foreach ($stationery as $stc) : ?>
								<div class=" col-md-2 col-lg-3 col-sm-3 col-xs-6 px-1 mb-2">
									<div class="card mb-3 shadow-md border-1 border py-2">
										<?php $img = ($stc->image) ? $stc->image : 'blank.png'; ?>
										<div class="img-responsive text-center" style="height:10rem">
											<img src="<?= base_url("assets/stationery/$img"); ?>" style="width:10rem;" class="card-img-top" alt="<?= $stc->name; ?>">
										</div>
										<div class="card-footer bg-white px-3 pt-3 pb-1 border-top-0 text-center">
											<!-- <h5 class="card-title text-center fw-bold"><?= $stc->name; ?></h5> -->
											<div class="d-grid">
												<button class="btn btn-light-primary btn-hover-primary fw-bold" data-bs-toggle="modal" data-bs-target="#ModalForm" id="choose-stationery" data-id="<?= $stc->id; ?>"><?= $stc->name; ?></button>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-5">
		<div class="card" style="height: 85vh;">
			<div class="card-header bg-white border-bottom-1 pb-1 ps-3 d-flex">
				<div class="pe-2">
					<i class="fa fa-user"> </i>
				</div>
				<div class="">
					<strong id="customer"><?= ($transactions) ? $transactions->customer_name . " - [" . $transactions->id . "]" : ''; ?></strong><br>
					<sub id="phone-text"><?= ($transactions) ? $transactions->phone : ''; ?></sub>
				</div>
				<?php if ($transactions) : ?>
					<?php if ($transactions->status !== 'DNE') : ?>
						<div class="text-end" style="flex:auto">
							<button type="button" title="Ubah" id="ubah" class="btn btn-sm text-primary"><i class="fa fa-pencil"></i></button>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<div class="text-end tools-customer" style="flex:auto">
						<button type="button" class="btn btn-sm text-primary" title="Tambah Pelanggan" id="tambah-pelanggan"><i class="fa fa-plus"></i></button>
					</div>
				<?php endif ?>
			</div>
			<div class="card-header bg-white h-100 p-0 overflow-auto">
				<?php $n = $subtotal = $diskon = $grand_total = 0;
				foreach ($trans_details as $dtl) : $n++;
					$subtotal 		+=  $dtl->subtotal;
					$diskon 		+=  $dtl->discount;
					$grand_total 	+=  $dtl->grand_total;
				?>
					<div class="card-body bg-gray-100 p-2 mt-2">
						<div class="row m-0">
							<div class="col-1">
								<?= $n; ?>
							</div>
							<div class="col-sm-5 px-1 m-0">
								<strong><?= $dtl->service_name; ?></strong> |
								<i><?= $dtl->material_name; ?></i><br>
								<?php if ($dtl->subtotal_size) : ?>
									<span><?= $dtl->length . 'x' . $dtl->width . '=' . $dtl->subtotal_size . $dtl->unit ?> </span><br>
								<?php endif; ?>
								<?php if ($dtl->file_name) : ?>
									<small><i class="fa fa-file-pdf-o"></i> <?= $dtl->file_name; ?></small>
								<?php endif; ?>
							</div>
							<div class="col-sm-2 px-1 m-0 text-end">
								<strong><?= number_format($dtl->price); ?></strong><br>
								<?php if ($dtl->unit_price) : ?>
									<small>@<?= number_format($dtl->unit_price); ?></small><br>
								<?php endif; ?>
							</div>
							<div class="col-sm-1 px-1 m-0 text-end">
								<strong><?= $dtl->qty; ?></strong>
							</div>
							<div class="col-sm-2 px-1 m-0 text-end">
								<strong class="text-primary"><?= number_format($dtl->grand_total); ?></strong>
								<?php if ($dtl->discount > 0) : ?>
									<small class="text-decoration-line-through"><?= number_format($dtl->subtotal); ?></small><br>
									<small class="text-danger">-<?= number_format($dtl->discount); ?></small><br>
								<?php endif; ?>
							</div>
							<div class="col-sm-1 px-1 m-0 text-end">
								<?php if ($transactions->status !== 'DNE') : ?>
									<button class="btn btn-sm text-danger hps" data-id="<?= $dtl->id; ?>"><i class="fa fa-times"></i></button>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="card-body">
				<!-- <hr> -->
				<div class="d-flex justify-content-between">
					<h5 class="">Subtotal</h5>
					<h5 class="text-end"><span class="subtotal"><?= ($subtotal) ? number_format($subtotal) : 0; ?></span>,-</h5>
				</div>
				<div class="discount_data ps-1">
					<div class="d-flex justify-content-between">
						<h5 class="text-muted">Diskon</h5>
						<h5 class=" text-muted text-end"><span class="discount_cost">-<?= ($diskon) ? number_format($diskon) : 0; ?></span>,-</h5>
					</div>
				</div>
				<hr>
				<div class="d-flex justify-content-between">
					<h3 class="fw-bold text-primary">Grand Total</h3>
					<h3 class="fw-bold text-end text-primary"><span><?= ($grand_total) ? number_format($grand_total) : 0; ?></span>,-</h3>
				</div>
				<hr>
				<div class="mt-2">
					<div class="row">
						<?php if ($transactions && $transactions->status !== 'DNE') : ?>
							<div class="col-md-8 mx-0 pe-0">
								<button class="btn btn-sm btn-light-primary text-primary" data-id="<?= ($transactions) ? $transactions->id : ''; ?>" id="cetak"><i data-feather="printer"></i></button>
								<button class="btn btn-light-success btn-sm text-success" onclick="simpan_trans('<?= ($transactions) ? $transactions->id : ''; ?>')" id="simpan-trans"><i data-feather="save"></i></button>
								<button type="button" title="Batal" id="batal" class="btn btn-light-warning btn-sm" style="color:orange"><i data-feather="x-circle"></i></button>
								<button type="button" title="Hapus" id="delete" class="btn btn-light-danger text-danger btn-sm"><i data-feather="trash"></i></button>
							</div>
							<div class="col-md-4 d-grid mx-0 ps-0">
								<?php if ($this->session->User['group_id'] == '4' || $this->session->User['group_id'] == '1') : ?>
									<button class="btn btn-danger" id="checkout" data-id="<?= ($transactions) ? $transactions->id : ''; ?>"><i data-feather="shopping-cart"></i> Bayar Sekarang</button>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalForm" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="title-modal"></h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<!-- <span aria-hidden="true">&times;</span> -->
				</button>
			</div>
			<div class="modal-body">
				<form id="form-transaction">
					<input type="hidden" name="trans_id" id="trans_id" class="form-control form-control-sm" value="<?= ($transactions) ? $transactions->id : ''; ?>">
					<div class="details"></div>
				</form>
			</div>

			<div class="modal-footer justify-content-between">
				<h4 class="fw-bold text-primary">Rp. <span class="loading"></span></h4>
				<h4 class="fw-bold text-end text-primary"><span class="grand_total">0</span>,-</h4>
			</div>

			<div class="modal-footer d-grid" style="justify-content: inherit;">
				<div class="row">
					<div class="col-md-6 d-grid px-1">
						<button type="button" id="save" disabled class="btn btn-primary rounded-pill"><i data-feather="shopping-bag" style="height: 0.95rem;margin-top: -3px;margin-right: -7px;"></i> Tambahkan</button>
					</div>
					<div class="col-md-6 d-grid px-1">
						<button type="button" class="btn btn-outline-primary rounded-pill" data-bs-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalCustomer" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Pelanggan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="load-form-customer"></div>
			</div>
			<div class="modal-footer d-grid" style="justify-content: unset;">
				<div class="row">
					<div class="col-md-6 d-grid px-1">
						<button type="button" class="btn btn-primary rounded-pill" id="save_customer"> <i data-feather="save" style="height: 0.95rem;margin-top: -3px;margin-right: px;"></i>Simpan</button>
					</div>
					<div class="col-md-6 d-grid px-1">
						<button type="button" class="btn btn-outline-primary rounded-pill" data-bs-dismiss="modal">Tutup</button>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalTrans" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">
					<button class="btn btn-default btn-icon btn-sm d-none" id="back_to_data"><i class="fa fa-arrow-left"></i></button> Data Transaksi
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="load-data"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-primary rounded-pill" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
		<div class="modal-content" id="load-form-payment">
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {

		$(document).on('keypress paste change', '#search', function() {
			let string = $(this).val();
			let html = img = '';
			$.ajax({
				url: siteurl + controller + 'search',
				type: 'POST',
				dataType: 'JSON',
				data: {
					string
				},
				success: function(result) {
					$.each(result, function(i, item) {
						if (item.image) {
							img = item.image;
						} else {
							img = 'blank.png'
						}

						html += `<div class="col-md-2 col-lg-3 col-sm-3 col-xs-6 px-1 mb-2">
									<div class="card mb-3">	
										<div class="img-responsive text-center" style="height:10rem">
											<img src="` + siteurl + `assets/services/` + img + `" style="width:10rem;" class="card-img-top" alt="` + item.name + `">
										</div>
										<div class="card-body text-center">
											
											<div class="d-grid">
												<button class="btn btn-light-primary btn-hover-primary fw-bold" data-bs-toggle="modal" data-bs-target="#ModalForm" id="choose-service" data-id="` + item.id + `">
													` + item.name + `
												</button>
											</div>
										</div>
									</div>
								</div>`

					});
					// html += `<div class="col-md-4 col-lg-3 col-sm-6 col-xs-6 px-1 mb-2">
					// 	<div class="d-grid">
					// 		<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalForm" id="choose-service" data-id="` + item.id + `" style="height:60px">
					// 			` + item.name + `
					// 		</button>
					// 		</div>
					// 	</div>
					// 		`

					$('#list-services').html(html)

				},
				error: function(result) {

				}
			})
		})

		$(document).on('click', '#choose-service', function() {
			let val = $(this).data('id');
			let title = $(this).text();
			$('.details').html('')
			$('#service').val('')
			$('#title-modal').text('')

			if (val) {
				$.ajax({
					url: siteurl + controller + 'load',
					type: 'POST',
					data: {
						val
					},
					success: function(result) {
						// console.log(result);
						if (result) {
							$('.details').html(result).show('ease')
							$('#service').val(val)
							$('#title-modal').text(title)

						} else {
							Swal.fire({
								title: "Oopps!",
								icon: 'warning',
								text: 'Form tidak terdaftar untuk jasa ini. Mohon periksa data form terlebih dahulu.'
							})
							$('.details').hide('ease')
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Internal Server Error!",
							icon: 'error',
							text: 'Mohon coba kembali beberapa saat nanti.'
						})
						$('.details').hide('ease')
					}
				})
			} else {
				$('.details').hide('ease')
			}
		})

		$(document).on('click', '#choose-stationery', function() {
			let val = $(this).data('id');
			let title = $(this).text();
			$('.details').html('').show('ease')
			$('#category_id').val('')
			$('#title-modal').text('')
			if (val) {
				$.ajax({
					url: siteurl + controller + 'load_stationery',
					type: 'POST',
					data: {
						val
					},
					success: function(result) {
						// console.log(result);
						if (result) {
							$('.details').html(result).show('ease')
							$('#category_id').val(val)
							$('#title-modal').text(title)
						} else {
							Swal.fire({
								title: "Oopps!",
								icon: 'warning',
								text: 'Data tidak valid.'
							})

							$('.details').hide('ease')
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Internal Server Error!",
							icon: 'error',
							text: 'Mohon coba kembali beberapa saat nanti.'
						})
						$('.details').hide('ease')
					}
				})
			} else {
				$('.details').hide('ease')
			}
		})

		$(document).on('change', '#length,#width', function() {
			let length = $('#length').val() || 0;
			let width = $('#width').val() || 0;
			let large = 0;
			let unit = $('#unit').val()

			if (unit == 'cm') {
				subtotal_size = parseFloat(length) * parseFloat(width)
				// total_size = parseFloat(large)
				$('#subtotal_size').val(subtotal_size) || 0;
				// $('#total_size').val(total_size) || 0;
			} else if (unit == 'm') {
				subtotal_size = parseFloat(length) * parseFloat(width)
				// total_size = parseFloat(large) / 100
				$('#subtotal_size').val(subtotal_size) || 0;
				// $('#total_size').val(total_size) || 0;
			}

			// large = parseFloat(length) * parseFloat(width)
			// total_size = parseFloat(large) * 100
			// $('#subtotal_size').val(large.toFixed(1)) || 0;
			// $('#total_size').val(total_size.toFixed(1)) || 0;
			getPrice()
		})

		$(document).on('change', '#material', function() {
			let id = $(this).val();
			let html = '';
			if (id) {
				$.ajax({
					url: siteurl + controller + 'load_price',
					type: 'POST',
					dataType: 'JSON',
					data: {
						id
					},
					success: function(result) {
						if (result) {
							if (result.materials.flag_custom_size == 'Y') {
								$('.custom-size').removeClass('d-none')
								$('#unit_price').val(new Intl.NumberFormat().format(result.materials.unit_price)) || 0;
								$('.unit_price').text("Rp. " + new Intl.NumberFormat().format(result.materials.unit_price) + " = Rp. " + new Intl.NumberFormat().format(result.materials.unit_price / 100) + " /cm") || 0;
								$('.unit').text(result.materials.unit);
								$('#unit').val(result.materials.unit);
								rate_custom()
							} else {
								$('.custom-size').addClass('d-none')
								$('#price').val(new Intl.NumberFormat().format(result.materials.unit_price)) || 0;
								rate_standard()
							}

							if (result.whPrice != '') {
								html += `
								<h5>List Harga</h5>
								<div class="alert alert-warning fade show" role="alert">
											<table class="table-condensed table-bordered table-sm" width="100%">
											<thead>
												<tr>
													<th colspan="2" class="text-center">Qty</th>
													<th colspan="" class="text-end">Harga</th>
												</tr>
											</thead>
											<tbody>`
								$.each(result.whPrice, function(i, item) {
									qty_until = item.qty_until ? item.qty_until : '^';
									html += `
										<tr>
											<td align="center">` + item.qty_from + `</td>
											<td align="center">` + qty_until + `</td>
											<td align="right">` + new Intl.NumberFormat().format(item.price) + `</td>
										</tr>`
								})
								html +=
									`</tbody>
											</table>
										</div>`
								$('#list-wholesale').html(html)
							} else {
								$('#list-wholesale').html('')
							}
						} else {
							Swal.fire({
								title: "Oopps!",
								icon: 'error',
								text: 'Mohon coba kembali beberapa saat nanti.'
							})
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Internal Server Error!",
							icon: 'error',
							text: 'Mohon coba kembali beberapa saat nanti.'
						})
					}
				})
			} else {
				$('.custom-size').addClass('d-none')
				$('#price,.price').val('');
				$('#list-wholesale').html('')
			}
		})

		// PRICE STATIONERY
		$(document).on('change', '#item', function() {
			let id = $(this).val();
			let html = '';
			if (id) {
				$.ajax({
					url: siteurl + controller + 'load_price_stationery',
					type: 'POST',
					dataType: 'JSON',
					data: {
						id
					},
					success: function(result) {
						if (result) {
							$('#price').val(new Intl.NumberFormat().format(result.stationery.unit_price)) || 0;
							rate_standard()

							if (result.whPrice != '') {
								html += `
								<h5>List Harga</h5>
								<div class="alert alert-warning fade show" role="alert">
											<table class="table-condensed table-bordered table-sm" width="100%">
											<thead>
												<tr>
													<th colspan="2" class="text-center">Qty</th>
													<th colspan="" class="text-end">Harga</th>
												</tr>
											</thead>
											<tbody>`
								$.each(result.whPrice, function(i, item) {
									qty_until = item.qty_until ? item.qty_until : '^';
									html += `
										<tr>
											<td align="center">` + item.qty_from + `</td>
											<td align="center">` + qty_until + `</td>
											<td align="right">` + new Intl.NumberFormat().format(item.price) + `</td>
										</tr>`
								})
								html +=
									`</tbody>
											</table>
										</div>`
								$('#list-wholesale').html(html)
							} else {
								$('#list-wholesale').html('')
							}
						} else {
							Swal.fire({
								title: "Oopps!",
								icon: 'error',
								text: 'Mohon coba kembali beberapa saat nanti.'
							})
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Internal Server Error!",
							icon: 'error',
							text: 'Mohon coba kembali beberapa saat nanti.'
						})
					}
				})
			} else {
				$('.custom-size').addClass('d-none')
				$('#price,.price').val('');
				$('#list-wholesale').html('')
			}
		})

		$(document).on('change', '#qty', function() {
			getPrice()
		})

		$(document).on('change', '#qty_stt', function() {
			getPriceStationery()
		})

		$(document).on('change', '#list_finishing', function() {
			let val = $(this).val()
			$('#finishing_data').val('');
			if (val == 'Custom') {
				$('#finishing_data').show('ease');
				$('#finishing_notes').val(val);

			} else {
				$('#finishing_data').hide('ease');
				$('#finishing_notes').val(val);
			}
		})

		$(document).on('change', '#discount', function() {
			let discount = $(this).val().replace(/[\.,]/g, '') || 0
			let subtotal = $('#total_price').val().replace(/[\.,]/g, '') || 0

			grand_total = parseFloat(subtotal) - parseFloat(discount)
			$('.grand_total').text(new Intl.NumberFormat().format(grand_total))

		})

		$(document).on('click', '#ubah', function() {
			let id = $('#trans_id').val();
			$.ajax({
				url: siteurl + controller + 'edit_customer',
				type: "POST",
				data: {
					id
				},
				success: function(result) {
					$('#modalCustomer').modal('show');
					$('#load-form-customer').html(result);
				},
				error: function(result) {
					Swal.fire({
						title: 'Gagal!',
						text: result.msg,
						icon: 'warning',
						timer: 3000
					})
				}
			})
		})

		$(document).on('click', '#tambah-pelanggan', function() {
			add_customer();
		})

		$(document).on('click', '#batal', function() {
			let id = $('#trans_id').val();
			if (id) {
				Swal.fire({
					title: 'Konfirmasi',
					text: 'Data Transaksi ini akan di batalkan?',
					icon: 'question',
					// reverseButtons: true,
					showCancelButton: true
				}).then((value) => {
					if (value.isConfirmed == true) {
						$.ajax({
							url: siteurl + 'trans/cancel',
							type: 'POST',
							dataType: 'JSON',
							data: {
								id
							},
							success: function(result) {
								if (result.status == 1) {
									Swal.fire({
										title: 'Berhasil!',
										text: result.msg,
										icon: 'success',
										timer: 3000
									}).then(function() {
										location.reload();
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
									text: 'Server timeout',
									icon: 'error',
									timer: 3000
								})
							}
						})
					}
				})
			}
		})

		$(document).on('click', '#delete', function() {
			let id = $('#trans_id').val();
			if (id) {
				Swal.fire({
					title: 'Hapus Transaksi',
					html: 'Transaksi yang sudah dihapus tidak bisa dikembalikan lagi. <i class="fa fa-trash text-danger"></i> ',
					icon: 'warning',
					// reverseButtons: true,
					showCancelButton: true
				}).then((value) => {
					if (value.isConfirmed == true) {
						$.ajax({
							url: siteurl + controller + 'deleteTrans',
							type: 'POST',
							dataType: 'JSON',
							data: {
								id
							},
							success: function(result) {
								if (result.status == 1) {
									Swal.fire({
										title: 'Berhasil!',
										text: result.msg,
										icon: 'success',
										timer: 3000
									}).then(function() {
										location.reload();
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
									text: 'Server timeout',
									icon: 'error',
									timer: 3000
								})
							}
						})
					}
				})
			}
		})

		$(document).on('click', '#save_customer', function() {
			let customer_name = $('#customer_name').val();
			let phone = $('#phone').val();
			if (!customer_name) {
				Swal.fire({
					title: 'Perhatian!',
					text: 'Nama Pelanggan Belum diisi.!',
					icon: 'warning',
					timer: 5000
				})
			} else if (!phone) {
				Swal.fire({
					title: 'Perhatian!',
					text: 'Nomor Telepon Pelanggan Belum diisi.!',
					icon: 'warning',
					timer: 5000
				})
			} else {
				let formData = new FormData($('#form-customer')[0])
				$.ajax({
					url: siteurl + controller + 'save_customer',
					data: formData,
					type: 'POST',
					contentType: false,
					processData: false,
					dataType: 'JSON',
					cache: false,
					async: false,
					success: function(result) {
						if (result.status == 1) {
							Swal.fire({
								title: "Berhasil!",
								icon: 'success',
								text: result.msg,
								timer: 2000
							})

							$('#customer').text(result.customer);
							$('#phone-text').text(result.phone);
							$('#trans_id').val(result.id);
							$('.tools-customer').html(`<button type="button" title="Ubah" id="ubah" class="btn btn-sm text-primary"><i class="fa fa-pencil"></i></button>`);
							$('#modalCustomer').modal('hide')
						} else {
							Swal.fire({
								title: "Gagal!",
								icon: 'error',
								text: result.msg,
								timer: 5000
							})
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Internal Server Error!",
							icon: 'error',
							text: result.msg
						})
					}

				})
			}

		})

		$(document).on('click', '#save', function() {
			save_details()
		})

		$(document).on('click', '#checkout,.payment', function() {
			let id = $(this).data('id');
			checkout(id);
		})

		$(document).on('click', '#save_payment', function() {
			let trans_id = $(this).data('id');
			let full_value = $('input[name="payment_type"]:checked').data('full_value');
			let need_document = $('input[name="payment_methode"]:checked').data('need_document');
			let document = $('input[type="file"][name="doc"]').length;
			let payment_value = $('#payment_value').val().replace(/[\,.-]/g, '') || 0;
			let bill = $('#sisa_tagihan').val().replace(/[\,.-]/g, '') || 0;
			if (!trans_id) {
				Swal.fire({
					title: "Peringatan!",
					icon: 'warning',
					text: 'Masukan nama pelanggan.'
				})
				return false;
			}

			if (parseFloat(bill) <= 0) {
				Swal.fire({
					title: "Peringatan!",
					icon: 'warning',
					text: 'Total tagihan tidak valid.'
				})
				return false;
			}

			if (!full_value) {
				Swal.fire({
					title: "Peringatan!",
					icon: 'warning',
					text: 'Pilih Jenis Bayar.'
				})
				return false;
			}

			if (!need_document) {
				Swal.fire({
					title: "Peringatan!",
					icon: 'warning',
					text: 'Pilih metode pembayaran.'
				})
				return false;
			}

			console.log(need_document + "," + document);
			if (need_document == 'Y' && document == 0) {
				Swal.fire({
					title: "Peringatan!",
					icon: 'warning',
					text: 'Bukti pembayaran belum di upload.'
				})
				return false;
			}

			if (!payment_value) {
				Swal.fire({
					title: "Peringatan!",
					icon: 'warning',
					text: 'Masukan jumlah pembayaran.'
				})
				return false;
			}

			if (parseFloat(payment_value) <= 0) {
				Swal.fire({
					title: "Peringatan!",
					icon: 'warning',
					text: 'Jumlah pembayaran tidak valid.'
				})
				return false;
			}
			if (full_value == 'Y' && parseFloat(payment_value) < parseFloat(bill)) {
				Swal.fire({
					title: "Peringatan!",
					icon: 'warning',
					text: 'Nilai pembayaran lunas masih kurang.'
				})
				return false;
			} else if ((full_value == 'N') && (parseFloat(payment_value) > parseFloat(bill))) {
				Swal.fire({
					title: "Peringatan!",
					icon: 'warning',
					text: 'Nilai pembayaran DP melebihi total tagihan.'
				})
				return false;
			} else {
				let formdata = new FormData($('#form-payment')[0])
				$.ajax({
					url: siteurl + controller + 'save_payment',
					type: 'POST',
					cache: false,
					data: formdata,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(result) {

						if (result.status == 1) {
							Swal.fire({
								title: "Success!",
								icon: 'success',
								html: `<div><p>Pembayaran Berhasil disimpan. </p>
										<h4>Kembalian</h4>
										<h4 class="text-danger">Rp.` + new Intl.NumberFormat().format(result.kembalian) + `,-</h4>
										</div>`,
								allowOutsideClick: false,
								showCancelButton: true,
								cancelButtonText: "Tutup",
								confirmButtonText: 'Print Struk'
							}).then((value) => {
								if (value.isConfirmed == true) {
									Cetak(trans_id);
								} else {
									location.reload();
									$('#paymentModal').modal('hide')
								}
							})
							checkout(trans_id);
							$('#save_payment').prop('disabled', true)
						} else {
							Swal.fire({
								title: "Gagal!",
								icon: 'error',
								text: result.msg,
								timer: 3000
							})
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Internal Server Error!",
							icon: 'error',
							text: 'Mohon coba kembali beberapa saat nanti.'
						})
					}
				})
			}

		})

		$(document).on('click', '#print_bill', function() {
			let id = $(this).data('id');
			Cetak(id);
		})

		$(document).on('click', '#cetak', function() {
			let id = $(this).data('id');
			Swal.fire({
				title: 'Konfirmasi',
				html: 'Cetak Struk Transaksi <span class="fa fa-print text-primary"></span> ? ',
				icon: 'question',
				showCancelButton: true,
				confirmButtonText: "Ya",
				cancelButtonText: "Tidak",
			}).then((value) => {
				if (value.isConfirmed == true) {
					Cetak(id);
				}
			})
		})

		$(document).on('click', '.hps', function() {
			let id = $(this).data('id');
			let trans_id = $('#trans_id').val();
			if (id) {
				Swal.fire({
					title: 'Konfirmasi',
					text: 'Data Transaksi ini akan di hapus?',
					icon: 'question',
					// reverseButtons: true,
					showCancelButton: true
				}).then((value) => {
					if (value.isConfirmed == true) {
						$.ajax({
							url: siteurl + controller + 'delete_item',
							type: 'POST',
							dataType: 'JSON',
							data: {
								id,
								trans_id
							},
							success: function(result) {
								if (result.status == 1) {
									Swal.fire({
										title: 'Berhasil!',
										text: result.msg,
										icon: 'success',
										timer: 3000
									}).then(function() {
										location.reload();
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
									text: 'Server timeout',
									icon: 'error',
									timer: 3000
								})
							}
						})
					}
				})
			}
		})

		$(document).on('click', '#view_transaction,#back_to_data', function() {
			$.ajax({
				url: siteurl + controller + 'view_transaction',
				type: 'POST',
				success: function(result) {
					if (result) {
						$('#load-data').html(result)
						$('#modalTrans').modal('show');
						$('.datatable').DataTable();
						$('#back_to_data').addClass('d-none')
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
		})

		$(document).on('click', '.view', function() {
			let id = $(this).data('id');

			if (id) {
				$.ajax({
					url: siteurl + '/trans/view',
					type: 'POST',
					data: {
						id
					},
					success: function(result) {
						if (result) {
							$('#modalTrans').modal('show');
							$('#load-data').html(result)
							$('#back_to_data').removeClass('d-none')
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

		$(document).on('change', '.payment-methode', function() {
			let need_document = $(this).data('need_document')
			if (need_document == 'Y') {
				$('.upload_document').load(siteurl + controller + 'upload_document');
			} else {
				$('.upload_document').html('');
			}
		})

		$(document).on('change', '#change_price', function() {
			let change_price = $(this).is(':checked')
			console.log(change_price);
			if (change_price == true) {
				$('#price').prop('readonly', false);
			} else {
				$('#price').prop('readonly', true);
				getPrice();
			}
		})

		$(document).on('change', '#price', function() {
			getPrice();
		})
	})

	function preview_image(event) {
		var reader = new FileReader();
		let old = event.target.files[0].name;
		reader.onload = function() {
			var output = document.getElementById('preview');
			output.src = reader.result;
		}
		reader.readAsDataURL(event.target.files[0]);
		// console.log(reader.readAsDataURL(event.target.files[0]));

	}


	function add_customer() {
		$.ajax({
			url: siteurl + controller + 'input_customer',
			type: "POST",
			success: function(result) {
				$('#modalCustomer').modal('show');
				$('#load-form-customer').html(result);
			},
			error: function(result) {
				Swal.fire({
					title: 'Gagal!',
					text: result.msg,
					icon: 'warning',
					timer: 3000
				})
			}
		})
	}

	function rate_standard() {
		let price = $('#price').val().replace(/[\.,]/g, "") || 0;
		let qty = $('#qty').val() || 0;
		let discount = $('#discount').val().replace(/[\.,]/g, "") || 0;
		subtotal = parseFloat(price) * parseFloat(qty);
		$('#total_price').val(new Intl.NumberFormat().format(subtotal));

		grand_total = parseFloat(subtotal) - parseFloat(discount);
		$('.grand_total').text(new Intl.NumberFormat().format(grand_total));

		if (grand_total > 0) {
			$('#save').prop('disabled', false);
		} else {
			$('#save').prop('disabled', true);
		}
	}

	function rate_custom() {
		let total_size = $('#total_size').val() || 0;
		let unit_price = $('#unit_price').val().replace(/[\.,]/g, "") || 0;
		let qty = $('#qty').val() || 0;
		let discount = $('#discount').val().replace(/[\.,]/g, "") || 0;

		// total_size = (parseFloat(total_size) * parseFloat(qty));
		// total_size = (parseFloat(subtotal_size) * parseFloat(qty)) * 100;
		price = parseFloat(total_size) * parseFloat(unit_price);
		console.log(total_size + ", " + unit_price + ", " + price);
		subtotal = (parseFloat(qty) * parseFloat(price));
		grand_total = parseFloat(subtotal) - parseFloat(discount);

		$('#price').val(new Intl.NumberFormat().format(price));
		$('#total_price').val(new Intl.NumberFormat().format(subtotal));
		$('.grand_total').text(new Intl.NumberFormat().format(grand_total));

		if (grand_total > 0) {
			$('#save').prop('disabled', false);
		} else {
			$('#save').prop('disabled', true);
		}
	}

	function Cetak(id = '') {
		if (id) {
			$.ajax({
				url: siteurl + controller + 'Cetak',
				type: 'POST',
				dataType: 'JSON',
				data: {
					id
				},
				success: function(result) {
					if (result.status == 1) {
						Swal.fire({
							title: "Print Struk!",
							icon: 'success',
							text: result.msg
						})
						location.reload();
					} else {
						Swal.fire({
							title: "Peringatan!",
							icon: 'warning',
							text: 'Printer bermasalah!.' + result.msg
						})
					}
				},
				error: function(result) {
					Swal.fire({
						title: "Error!",
						icon: 'error',
						text: 'Printer bermasalah!.' + result.msg
					})
				}
			})
		} else {
			Swal.fire({
				title: "Informasi!",
				icon: 'info',
				text: 'Transaksi tidak valid.'
			})
		}
	}

	function checkout(trans_id = '') {
		if (!trans_id) {
			let trans_id = $('#trans_id').val();
		}
		if (trans_id) {
			$.ajax({
				url: siteurl + controller + 'checkout',
				type: 'POST',
				data: {
					trans_id
				},
				success: function(result) {
					$('#paymentModal').modal('show');
					$('#load-form-payment').html(result);
				},

				error: function(result) {
					Swal.fire({
						title: "Internal Server Error!",
						icon: 'error',
						text: 'Mohon coba kembali beberapa saat nanti.'
					})
				}
			})
		} else {
			Swal.fire({
				title: "Perhatian!",
				icon: 'warning',
				text: 'Data transaksi tidak valid.'
			})
		}
	}

	function save_details() {
		let id = $('#trans_id').val();
		let service = $('#service').val();
		let material = $('#material').val();
		let qty = $('#qty').val();

		if (!id) {
			Swal.fire({
				title: 'Peringatan!',
				text: 'Data pelanggan masih kosong. Masukan data Pelanggan?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: "Ya",
			}).then((value) => {
				if (value.isConfirmed == true) {
					add_customer()
				}
			})
			return false;

		} else {
			let formData = new FormData($('#form-transaction')[0])
			if (formData) {
				$.ajax({
					url: siteurl + controller + 'save_detail',
					data: formData,
					type: 'POST',
					contentType: false,
					processData: false,
					dataType: 'JSON',
					cache: false,
					async: false,
					success: function(result) {
						if (result.status == 1) {
							Swal.fire({
								title: "Berhasil!",
								icon: 'success',
								text: result.msg,
								timer: 2000
							}).then(function() {
								location.reload();
							})
						} else {
							Swal.fire({
								title: "Gagal!",
								icon: 'error',
								text: result.msg,
								timer: 5000
							})
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Internal Server Error!",
							icon: 'error',
							text: result.msg
						})
					}

				})
			} else {
				Swal.fire({
					title: 'Error!',
					text: 'Server Timeout.',
					icon: 'error',
					timer: 3000,
				})
			}
		}
	}

	function kembali() {
		$('#data_customer').show('ease');
		$('#form-customer').hide('ease');
	}

	function simpan_trans(id) {
		if (id) {
			Swal.fire({
				title: 'Konfirmasi',
				text: 'Data Transaksi ini akan di simpan?',
				icon: 'question',
				// reverseButtons: true,
				showCancelButton: true
			}).then((value) => {
				if (value.isConfirmed == true) {
					$.ajax({
						url: siteurl + controller + 'save_trans',
						type: 'POST',
						dataType: 'JSON',
						data: {
							id
						},
						success: function(result) {
							if (result.status == 1) {
								location.reload();
							} else {
								Swal.fire({
									title: 'Perhatian!',
									text: 'Gagal menyimpan data.',
									icon: 'warning',
									timer: 3000
								})
							}
						},
						error: function(result) {
							Swal.fire({
								title: 'Error!',
								text: 'Server timeout.',
								icon: 'error',
								timer: 3000
							})
						}

					})
				}
			})
		} else {
			Swal.fire({
				title: 'Informasi',
				text: 'Data transaksi tidak valid.',
				icon: 'warning',
				timer: 3000
			})
		}
	}

	function getPrice() {
		let qty = $('#qty').val() || 0;
		let unit = $('#unit').val() || 0;
		let material = $('#material').val() || 0;
		let discount = $('#discount').val().replace(/[\.,]/g, "") || 0;
		let unit_price = $('#unit_price').val().replace(/[\.,]/g, "") || 0;
		let subtotal_size = $('#subtotal_size').val() || 0;
		let change_price = $('#change_price').is(':checked');
		let size = 0;

		size = parseFloat(qty) * parseFloat(subtotal_size);
		// if (unit == 'cm') {
		// } else if (unit == 'm') {
		// 	size = (parseFloat(qty) * parseFloat(subtotal_size)) * 100;
		// }
		// console.log(size);

		$('#total_size').val(size)

		loading()
		if (material) {
			if (change_price == true) {
				rate_standard();
			} else {
				$.ajax({
					url: siteurl + controller + 'wholesale_price',
					type: 'POST',
					dataType: 'JSON',
					data: {
						material,
						qty,
						size,
					},
					success: function(result) {
						if (result.material.flag_custom_size == 'Y') {
							$('#unit_price').val(new Intl.NumberFormat().format(result.price)) || 0;
							$('.unit_price').text("Rp. " + new Intl.NumberFormat().format(result.price) + " /" + (result.unit) ? result.unit : '') || 0;

							price = parseFloat(subtotal_size) * parseFloat(result.price);
							subtotal = parseFloat(qty) * parseFloat(price);
							grand_total = parseFloat(subtotal) - parseFloat(discount);

							$('#price').val(new Intl.NumberFormat().format(price));
							$('#total_price').val(new Intl.NumberFormat().format(subtotal));
							$('.grand_total').text(new Intl.NumberFormat().format(grand_total));

							if (grand_total > 0) {
								$('#save').prop('disabled', false);
							} else {
								$('#save').prop('disabled', true);
							}

						} else if (result.material.flag_custom_size == 'N') {
							$('#price').val(new Intl.NumberFormat().format(result.price)) || 0;
							rate_standard()
						} else {
							Swal.fire({
								title: "Oopps!",
								icon: 'warning',
								text: 'No Data...'
							})
							$('#qty,#price,.price').val(0);
						}

						if (qty <= 0) {
							$('#qty,#price,.price').val(0);
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Internal Server Error!",
							icon: 'error',
							text: 'Mohon coba kembali beberapa saat nanti.'
						})
						return false
					}
				})
			}
		} else {
			Swal.fire({
				title: 'Peringatan!',
				text: 'Jenis Bahan belum dipilih. Mohon memilih jenis Bahan terlebih dahulu!',
				icon: 'warning',
				timer: 5000
			})
			$('#qty').val('').change()
			return false;
		}
	}

	function getPriceStationery() {
		let qty = $('#qty_stt').val() || 0;
		let id = $('#item').val() || 0;
		let discount = $('#discount').val().replace(/[\.,]/g, "") || 0;
		let price = $('#price').val().replace(/[\.,]/g, "") || 0;
		let change_price = $('#change_price').is(':checked');
		loading()

		if (id) {
			if (change_price == true) {
				rate_standard();
			} else {
				$.ajax({
					url: siteurl + controller + 'wholesale_price_stationery',
					type: 'POST',
					dataType: 'JSON',
					data: {
						id,
						qty,
					},
					success: function(result) {
						if (result) {
							$('#unit_price').val(new Intl.NumberFormat().format(result.price)) || 0;
							$('#price').val(new Intl.NumberFormat().format(result.price)) || 0;
							rate_standard()

							subtotal = parseFloat(price) * parseFloat(qty);
							$('#total_price').val(new Intl.NumberFormat().format(subtotal));

							grand_total = parseFloat(subtotal) - parseFloat(discount);
							$('.grand_total').text(new Intl.NumberFormat().format(grand_total));

							if (grand_total > 0) {
								$('#save').prop('disabled', false);
							} else {
								$('#save').prop('disabled', true);
							}
						} else {
							Swal.fire({
								title: "Oopps!",
								icon: 'warning',
								text: 'No Data...'
							})

							$('#qty_stt,#price,.price').val(0);
						}

						if (qty <= 0) {
							$('#qty_stt,#price,.price').val(0);
						}
					},
					error: function(result) {
						Swal.fire({
							title: "Internal Server Error!",
							icon: 'error',
							text: 'Mohon coba kembali beberapa saat nanti.'
						})
						return false
					}
				})
			}
		} else {
			Swal.fire({
				title: 'Peringatan!',
				text: 'Jenis Bahan belum dipilih. Mohon memilih jenis Bahan terlebih dahulu!',
				icon: 'warning',
				timer: 5000
			})
			$('#qty').val('').change()
			return false;
		}
	}

	function loading() {
		$.ajax({
			beforeSend: function() {
				$('.loading').html('<img src="' + siteurl + 'assets/loading-animation.webp' + '" className="img-fluid" width="20px"/>');
			},
			complete: function() {
				$('.loading').html('');
			}
		})
	}
</script>