<div class="bg-white shadow-none line-height-0" id="section-to-print">
	<div class="card-body">
		<button type="button" class="btn btn-danger d-print-none" onclick="history.go(-1)"><i class="fa fa-arrow-left"></i></button>
		<button type="button" class="btn btn-primary d-print-none" onclick="printDiv()"><i class="fa fa-print"></i></button>
		<!-- <hr> -->
		<?php
		$sts = [
			'OPN' => '<span class="text-primary">Open</span>',
			'CLS' => '<span class="text-secondary">Close</span>'
		]; ?>
		<table class="table table-borderless table-sm nowrap">
			<tbody>
				<tr>
					<th class="text-center" colspan="2">
						<h3 class="text-black"><strong>LAPORAN SHIFT</strong></h3>
					</th>
				</tr>
				<tr class="table-secondary mt-3">
					<th class="text-black">Nama Kasir</th>
					<th class="text-end" width="200px"> <span><?= ($shift->full_name) ?: '~'; ?></span></th>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Mulai Shift</td>
					<td nowrap class="text-end"> <span><?= ($shift->start_shift) ?: '~'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Akhir Shift</td>
					<td nowrap class="text-end"> <span><?= ($shift->end_shift) ?: '~'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Status</td>
					<td nowrap class="text-end"> <span><?= ($sts[$shift->status]) ?: '~'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Uang Masuk</td>
					<td class="text-end"> <span><?= ($shift->qty_income) ?: '0'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Uang Keluar</td>
					<td class="text-end"> <span><?= ($shift->qty_expense) ?: '0'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Transaksi</td>
					<td class="text-end"> <span><?= ($shift->qty_transactions) ?: '0'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Produk Terjual</td>
					<td class="text-end"> <span><?= ($shift->qty_sales_product) ?: '0'; ?></span></td>
				</tr>
				<tr class="table-secondary">
					<th>Saldo</th>
					<th></th>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Saldo Awal</td>
					<td class="text-end"> <span>Rp. <?= (number_format($shift->beginning_balance)) ?: '0'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Total Penjualan</td>
					<td class="text-end"> <span>Rp. <?= (number_format($shift->cash_sales)) ?: '0'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Perkiraan Saldo Akhir</td>
					<td class="text-end"> <span>Rp. <?= (number_format($shift->expected_ending_balance)) ?: '0'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Pembayaran Tunai</td>
					<td class="text-end"> <span>Rp. <?= (number_format($shift->cash_payment)) ?: '0'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Total Uang Masuk</td>
					<td class="text-end"> <span>Rp. <?= (number_format($shift->income)) ?: '0'; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Total Uang Keluar</td>
					<td class="text-end"> <span>Rp. <?= (number_format($shift->expenses)) ?: '0'; ?></span></td>
				</tr>
				<tr class="table-light">
					<th>Saldo Akhir</th>
					<th class="text-end"> <span>Rp. <span id="ending_balance_text"><?= (number_format($shift->ending_balance)) ?: '0'; ?></span></span></th>
				</tr>
				<tr class="table-secondary">
					<th>Jumlah Uang</th>
					<th class="text-end"> Rp. <?= number_format($shift->actual_ending_balance); ?></th>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Selisih</td>
					<td class="text-end"> Rp.<?= number_format($shift->difference); ?></td>
				</tr>
			</tbody>
		</table>
		<h5 class="fw-bold text-black">Keterangan</h5>
		<p>
			<?= ($shift->note); ?>
		</p>
	</div>
</div>
<style>
	@media print {
		body * {
			visibility: hidden;

		}

		body {
			background-color: #fff !important;
		}

		#section-to-print,
		#section-to-print * {
			visibility: visible;
			padding: 0;
			margin: 0;
			width: 100%;
		}

		#section-to-print div.row {
			height: 15px;
		}

		#section-to-print {
			position: absolute;
			left: 0;
			top: 0;
		}
	}
</style>
<script>
	function printDiv() {
		// var divToPrint = document.getElementById('toPrint');
		// newWin = window.open();
		// newWin.document.write(divToPrint.outerHTML);
		window.print();
		// window.close();
	}
</script>