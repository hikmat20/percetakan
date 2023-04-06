<?php $n = 0;
foreach ($loadData as $dt) : $n++; ?>
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