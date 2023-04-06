<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Print SPK</title>


	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<script src="<?= base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
	<link href="<?= base_url(); ?>themes/dashboard/assets/plugins/global/plugins.bundle1036.css?v=2.1.1" rel="stylesheet" type="text/css" />
	<link href="<?= base_url(); ?>themes/dashboard/assets/css/style.bundle1036.css?v=2.1.1" rel="stylesheet" type="text/css" />
	<script src="<?= base_url('assets/dist/sweetalert.min.js'); ?>"></script>

</head>

<body class="bg-white">
	<div class="px-5 mt-5">
		<div class="col-6 mb-5">
			<div class="card shadow-sm border-0">
				<div class="card-body" id="print-area">
					<table class="table table-bordered border-3 table-sm table-condensed">
						<thead>
							<tr class="text-center">
								<th class="p-1">Tanggal</th>
								<th class="p-1">Operator Komputer</th>
								<th class="p-1">Operator Spanduk</th>
								<th class="p-1">Konsumen</th>
							</tr>
							<tr class="text-center">
								<td> <?= $transactions->date; ?></td>
								<td><?= ucfirst($transactions->created_by_name); ?></td>
								<td></td>
								<td>
									<?= $transactions->customer_name; ?><br>
									<?= ($transactions->phone) ?: ''; ?>
								</td>
							</tr>
						</thead>
					</table>
					<table class="table table-bordered border-3 table-sm table-condensed">
						<thead>
							<tr>
								<th>NO</th>
								<th>NAMA FILE</th>
								<th>BAHAN</th>
								<th>UKURAN</th>
								<th>FINISHING</th>
								<th>QTY</th>
								<th>KET.</th>
							</tr>
						</thead>
						<tbody>
							<?php $n = 0;
							foreach ($trans_details as $dt) : $n++ ?>
								<tr>
									<td><?= $n; ?></td>
									<td>
										<?= ($dt->file_name) ? $dt->file_name : ''; ?>
									</td>
									<td><?= $dt->products_detail_name; ?></td>
									<td class="text-end"><?= ($dt->width) ? "Ukuran : " . $dt->width . "x" . $dt->length . "=" . $dt->subtotal_size . "m<br>" : ''; ?></td>
									<td><?= $dt->finishing_notes; ?></td>
									<td class="text-center"><?= ($dt->qty); ?></td>
									<td><?= $dt->notes; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="7">
									<h6>KETERANGAN : </h6>
									<br>
									<br>
									<br>
									<br>
								</th>
							</tr>
						</tfoot>
					</table>

				</div>
			</div>
		</div>
		<div class="col-6">
			<button type="button" class="btn btn-primary d-print-none" onclick="printSection('print-area')"><i class="fa fa-print"></i> Print</button>
		</div>

	</div>

	<script src="<?= base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
	<script>
		function print_area() {
			var prtContent = document.getElementById("print-area");
			// var WinPrint = window.open('', '');
			// WinPrint.document.write(prtContent.innerHTML);
			window.print();
			prtContent.document.close();
			prtContent.focus();
			prtContent.close();
		}

		function printSection(el) {
			var getFullContent = document.body.innerHTML;
			var printsection = document.getElementById(el).innerHTML;
			document.body.innerHTML = printsection;
			window.print();
			document.body.innerHTML = getFullContent;
		}
	</script>
</body>

</html>