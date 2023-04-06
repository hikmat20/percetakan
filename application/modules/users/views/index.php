<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				<div class="d-flex justify-content-between">
					<h3 class="card-title"> <?= $title; ?></h3>
					<a href="<?= site_url('users/setting/create') ?>" class="btn btn-success float-right" title="<?= lang('users_btn_new') ?>">
						<i data-feather="user-plus" width="18px"></i> <?= lang('users_btn_new') ?></a>
				</div>
				<div class="data-table mt-7 table-">
					<table id="example1" class="table table-bordered table-condensed table-sm">
						<thead class="table-light fw-bolder">
							<tr>
								<th width="20px">#</th>
								<th>User</th>
								<th>Email</th>
								<th>Nama Lengkap</th>
								<th>Telepon</th>
								<th>Jabatan</th>
								<th>Aktif</th>
								<th width="">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php $n = 0;
							foreach ($results as $record) : $n++ ?>
								<tr>
									<td><?= $n; ?></td>
									<td><?= $record->username ?></td>
									<td><?= $record->email ?></td>
									<td><?= $record->full_name ?></td>
									<td><?= $record->phone ?></td>
									<td class="text-center">
										<span class='badge rounded-pill bg-info'><?= $pos[$record->group_id] ?></span>
									</td>
									<td>
										<?= $status[$record->active] ?>
									</td>
									<td>
										<a class="btn btn-warning btn-sm" href="<?= site_url('users/setting/edit/' . $record->id_user); ?>" data-toggle="tooltip" data-placement="left" title="Edit Data">
											<i data-feather="edit-3" width="18px" class="fa fa-pencil"></i></a>
										<?php if ($record->id_user != 1) : ?>
											<!-- <a class="btn btn-primary btn-sm" href="<?= site_url('users/setting/permission/' . $record->id_user); ?>" data-toggle="tooltip" data-placement="left" title="Edit Hak Akses"> -->
											<!-- <i data-feather="shield" width="18px" class="fa fa-shield"></i></a> -->
										<?php endif; ?>
									</td>
								</tr>
							<?php
							endforeach; ?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>