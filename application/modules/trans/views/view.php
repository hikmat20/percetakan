<div class="">
	<table class="table table-responsive-sm table-sm table-borderless">
		<tbody>
			<tr>
				<td width="20%">No. Transaksi</td>
				<td>: <?= $transactions->id; ?></td>
			</tr>
			<tr>
				<td>Pelanggan</td>
				<td>: <?= $transactions->customer_name; ?></td>
			</tr>
			<tr>
				<td>Telepon</td>
				<td>: <?= $transactions->phone; ?></td>
			</tr>
			<tr>
				<td>Tgl/Jam</td>
				<td>: <?= $transactions->date; ?></td>
			</tr>
		</tbody>
	</table>

	<table class="table table-sm table-bordered">
		<thead class="table-light">
			<tr>
				<th width="20px">No</th>
				<th>Barang/Jasa</th>
				<th class="text-end">Harga</th>
				<th class="text-center">Qty</th>
				<th class="text-end">Subtotal</th>
				<th class="text-end">Diskon</th>
				<th class="text-end">Total</th>
				<th class="text-end">Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<?php $n = 0;
			foreach ($trans_details as $dt) : $n++ ?>
				<tr>
					<td><?= $n; ?></td>
					<td>
						<span class="fw-bold"><?= $dt->products_detail_name; ?></span><br>
						<?= ($dt->width) ? "Ukuran : " . $dt->width . "x" . $dt->length . "=" . $dt->subtotal_size . "m<br>" : ''; ?>
						<?= ($dt->unit_price) ? "Harga : @" . number_format($dt->unit_price) . '<br>' : ''; ?>
						<?= ($dt->file_name) ? '<small><i class="fa fa-file-pdf-o"></i>' . $dt->file_name . '</small>' : ''; ?>
					</td>
					<td class="text-end"><?= number_format($dt->price); ?></td>
					<td class="text-center"><?= ($dt->qty); ?></td>
					<td class="text-end"><?= number_format($dt->subtotal); ?></td>
					<td class="text-end text-danger">-<?= number_format($dt->discount); ?></td>
					<td class="text-end"><?= number_format($dt->grand_total); ?></td>
					<td><?= $dt->notes; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-6">
		<table class="table table-sm table-borderlss">
			<thead>
				<tr>
					<th>Jns. Bayar</th>
					<th>Jns. Pembayaran</th>
					<th>Nominal</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($payment as $pay) : ?>
					<tr>
						<td><?= $pay->payment_type_name; ?></td>
						<td><?= $pay->payment_methode_name; ?></td>
						<td class="text-end"> <?= number_format($pay->payment_value); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div class="col-md-6">
		<div class="text-end">
			<table class="table table-condensed table-sm table-borderless">
				<tbody>
					<tr class="fw-bold">
						<td width="">Subtotal</td>
						<td width="10px">:</td>
						<td width="" class="text-end"><?= number_format($transactions->subtotal); ?></td>
					</tr>
					<tr>
						<td>Diskon</td>
						<td width="">:</td>
						<td class="text-end text-danger">-<?= number_format($transactions->discount); ?></td>
					</tr>
					<tr class="fs-3 fw-bold text-success">
						<td>Total</td>
						<td width="">:</td>
						<td class="text-end"><?= number_format($transactions->grand_total); ?></td>
					</tr>
					<tr>
						<td>Total Pembayaran</td>
						<td width="">:</td>
						<td class="text-end"><?= number_format($transactions->total_payment); ?></td>
					</tr>
					<tr>
						<td>Sisa</td>
						<td width="">:</td>
						<td class="text-end fw-bold fs-4 text-primary"><?= number_format($transactions->balance); ?></td>
					</tr>
					<tr class="text-info">
						<td>Kembalian</td>
						<td width="">:</td>
						<th class="text-end"><?= number_format($transactions->return); ?></th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-3">
		<button type="button" class="btn btn-primary btn-sm" title="Print Struk" data-id="<?= $transactions->id; ?>" id="print_bill"><i class="fa fa-print"></i> Print Struk</button>
		<a href="<?= base_url($this->uri->segment(1) . "/print_spk/" . $transactions->id); ?>" class="btn btn-info btn-sm" target="_blank" title="Print SPK" data-id="<?= $transactions->id; ?>" id="print_spk"><i class="fa fa-print"></i> Print SPK</a>
	</div>