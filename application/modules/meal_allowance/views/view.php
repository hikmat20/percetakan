<div class="">
	<table class="table table-responsive-sm table-sm table-borderless">
		<tbody>
			<tr>
				<td width="20%">Karyawan</td>
				<td class="fw-bold text-secondary">: <?= $cashReceipt->employee_name; ?></td>
			</tr>

		</tbody>
	</table>
	<!-- cashReceipt
	dataKasbon -->

	<p class="fw-bold"><i class="fa fa-history"></i> Riwayat Kasbon</p>
	<table class="table table-sm table-bordered">
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
			<?php $n = 0;
			foreach ($dataKasbon as $dt) : $n++ ?>
				<tr>
					<td><?= $n; ?></td>
					<td><?= $dt->date; ?></td>
					<td><?= $dt->description; ?></td>
					<td class="text-end"><?= number_format($dt->cash_value); ?></td>
					<td></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot class="table-light">
			<tr>
				<th colspan="3" class="text-end">Total</th>
				<th class="text-end"><?= number_format($cashReceipt->cash_value); ?></th>
				<th></th>
			</tr>
		</tfoot>
	</table>
	<hr>
	<p class="fw-bold"><i class="fa fa-history"></i> Riwayat Bayar Kasbon</p>
	<table class="table table-sm table-bordered">
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
						<td></td>
					</tr>
			<?php endforeach;
			endif; ?>
		</tbody>
		<tfoot class="table-light">
			<tr>
				<th colspan="2" class="text-end">Total</th>
				<th class="text-end"><?= (isset($cashReceipt->total_payment)) ? number_format($cashReceipt->total_payment) : ''; ?></th>
				<th></th>
			</tr>
		</tfoot>
	</table>
	<br>

	<div class="card">
		<div class="card-body d-flex justify-content-between align-content-center">
			<h4 class="card-title">Sisa Kasbon</h4>
			<h3 class="card-text fw-bold  text-danger">Rp. <?= number_format($cashReceipt->sisa_kasbon); ?></h3>
		</div>
	</div>
</div>