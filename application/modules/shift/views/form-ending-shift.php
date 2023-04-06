 <div class="row mb-3">
 	<div class="col-md-12">
 		<div class="alert alert-secondary text-center" role="alert">
 			<strong>SHIFT SAAT INI</strong>
 		</div>

 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Nama Kasir</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end fw-bold">
 			<span><?= ($shift->username) ?: '~'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Mulai Shift</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span><?= ($shift->start_shift) ?: '~'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Uang Masuk</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span><?= ($shift->qty_income) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Uang Keluar</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span><?= ($shift->qty_expense) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Transaksi</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span><?= ($shift->qty_transactions) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Produk Terjual</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span><?= ($shift->qty_sales_product) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3 mt-5">
 	<div class="col-md-6">
 		<label class="form-label fw-bold h4">Saldo</label>
 	</div>
 	<div class="col-md-6">
 	</div>
 </div>
 <hr>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Saldo Awal</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span>Rp. <?= (number_format($shift->beginning_balance)) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Total Penjualan</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span>Rp. <?= (number_format($shift->cash_sales)) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label fw-bold">Perkiraan Saldo Akhir</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span>Rp. <?= (number_format($shift->expected_ending_balance)) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <hr>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Pembayaran Tunai</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span>Rp. <?= (number_format($shift->cash_payment)) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Total Uang Masuk</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span>Rp. <?= (number_format($shift->income)) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label">Total Uang Keluar</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span>Rp. <?= (number_format($shift->expenses)) ?: '0'; ?></span>
 		</div>
 	</div>
 </div>
 <hr>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label fw-bold">Saldo Akhir</label>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<span>Rp. <span id="ending_balance_text"><?= (number_format($shift->ending_balance)) ?: '0'; ?></span></span>
 		</div>
 	</div>
 </div>
 <hr>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label fw-bold name">Jumlah Uang</label><br>
 		<small>Masukan jumlah uang yang didapatkan</small>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid">
 			<input type="text" name="actual_ending_balance" id="actual_ending" class="form-control numeric currency text-end" placeholder="Rp. 0">
 			<small class="invalid-feedback text-danger">Mohon input saldo akhir aktual!</small>
 		</div>
 	</div>
 </div>
 <div class="row mb-3">
 	<div class="col-md-6">
 		<label class="form-label fw-bold name">Selisih</label><br>
 	</div>
 	<div class="col-md-6">
 		<div class="d-grid text-end">
 			<input type="text" name="difference" readonly id="difference" class="form-control text-end" placeholder="Rp. 0">
 		</div>
 		<div class="d-grid text-end mt-3">
 			<textarea name="note" id="note" class="form-control" placeholder="Keterngan"></textarea>
 		</div>
 	</div>
 </div>
 <hr>
 <div class="d-grid mt-3">
 	<button type="button" id="ending_shift" class="btn btn-danger">Akhiri Shitf</button>
 </div>