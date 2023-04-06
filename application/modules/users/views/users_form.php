<div class="row">
	<div class="col-lg-12 col-md-12 col-12">
		<!-- Page header -->
		<div>
			<div class="border-bottom pb-4 mb-4 d-flex align-items-center
                  justify-content-between">
				<div class="mb-2 mb-lg-0">
					<h3 class="mb-0 fw-bold"><?= $title; ?></h3>
				</div>
				<button type="button" onclick="location.href=siteurl+controller+'setting'" class="btn btn-sm btn-danger"><i class="fa fa-reply"></i> Kembali</button>
			</div>
		</div>
	</div>
</div>

<!-- form start -->
<div class="row mb-4">
	<div class="col-xl-3 col-lg-4 col-md-12 col-12">
		<div class="mb-4 mb-lg-0">
			<h4 class="mb-1">Informasi Data Pengguna</h4>
			<p class="mb-0 fs-5 text-muted">Pengaturan data profil pengguna </p>
		</div>
	</div>

	<div class="col-xl-9 col-lg-8 col-md-12 col-12">
		<div class="card">
			<div class="card-body">
				<div class="mb-6">
					<h4 class="mb-1">Informasi Dasar</h4>
				</div>
				<form id="frm_users" name="frm_users" enctype="multipart/form-data">
					<!-- row -->
					<div class="mb-3 row">
						<label for="full_name" class="col-sm-4 col-form-label
                          form-label">Nama Lengkap</label>
						<div class="col-md-8 col-12">
							<input type="hidden" name="id_user" value="<?= set_value('id_user', isset($data->id_user) ? $data->id_user : ''); ?>">
							<input type="text" name="full_name" class="form-control" placeholder="Nama Lengkap" value="<?= set_value('full_name', isset($data->full_name) ? $data->full_name : ''); ?>" id="full_name" required>
						</div>
					</div>

					<!-- row -->
					<div class="mb-3 row">
						<label for="email" class="col-sm-4 col-form-label
                          form-label">Email</label>
						<div class="col-md-8 col-12">
							<input type="email" name="email" class="form-control" value="<?= set_value('email', isset($data->email) ? $data->email : ''); ?>" placeholder="Email" id="email" required>
						</div>
					</div>
					<!-- row -->
					<div class="mb-3 row">
						<label for="phone" class="col-sm-4 col-form-label
                          form-label">Telepon</label>
						<div class="col-md-8 col-12">
							<input type="text" name="phone" class="form-control" placeholder="+62 ..." id="phone" value="<?= set_value('phone', isset($data->phone) ? $data->phone : ''); ?>" required>
						</div>
					</div>
					<!-- row -->
					<div class="mb-3 row">
						<label for="location" class="col-sm-4 col-form-label form-label">Jabatan</label>
						<div class="col-md-8 col-12">
							<select name="group_id" class="form-control select">
								<option></option>
								<?php foreach ($position as $ps) : ?>
									<option value="<?= $ps->id; ?>" <?= (isset($data->group_id)) ? (($data->group_id == $ps->id) ? 'selected' : '') : ''; ?>><?= $ps->position_name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="location" class="col-sm-4 col-form-label form-label">Status</label>
						<div class="col-md-8 col-12">
							<div class="form-check form-switch">
								<input class="form-check-input" name="active" type="checkbox" id="status" <?= (isset($data->active)) ? (($data->active == 'Y') ? 'checked' : '') : ''; ?> value="<?= (isset($data->active)) ? $data->active : ''; ?>">
								<label class="form-check-label cek_status" for="status"><?= (isset($data->active) == 'Y') ? (($data->active == 'Y') ? 'Aktif' : 'Tidak Aktif') : 'Tidak Aktif'; ?></label>
							</div>
						</div>
					</div>

					<div class="mb-3 row">
						<label for="location" class="col-sm-4 col-form-label form-label">Avatar</label>
						<div class="col-md-8 col-12">
							<div class="d-flex align-items-center">
								<div class="me-3">
									<img id="preview" src="<?= base_url('assets/images/avatar/') . set_value('photo', isset($data->photo) ? $data->photo : 'avatar.png') ?>" alt="<?= isset($data->photo) ? $data->photo : 'avatar.png' ?>" class="rounded-circle avatar avatar-lg avatar-xxl rounded-circle border border-4 border-white-color-40" alt="">
								</div>
								<!-- <div>
								<button type="submit" class="btn btn-outline-white me-1">Change</button>
								<button type="submit" class="btn btn-outline-white">Remove</button>
							</div> -->
							</div>
							<div class="mt-4">
								<input type="file" name="photo" onchange="preview_image(event)" id="photo" class="d-none">
								<input type="hidden" name="old_photo" id="old_photo" value="<?= isset($data->photo) ? $data->photo : '' ?>">
								<button class="btn btn-warning" onclick="$('#photo').click()" type="button"><i class="fa fa-upload"></i> Upload</button>
							</div>
							<div class="mt-2">
								<small class="text-center text-muted font-size-20">
									*) Ukuran Max. 500kb, Dimensi Max. 1000 x 1000 pixel
								</small>
							</div>
						</div>
					</div>
					<!-- row -->
					<div class="row align-items-center">
						<div class="offset-md-4 col-md-8 mt-4">
							<button id="save_user" type="button" class="btn btn-primary"><i data-feather="save" width="18px"></i> Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div><!-- /.box -->


<form id="frm_account">
	<div class="row">
		<div class="col-xl-3 col-lg-4 col-md-12 col-12">
			<div class="mb-4 mb-lg-0">
				<h4 class="mb-1">Pengaturan Sandi</h4>
				<p class="mb-0 fs-5 text-muted">Pengaturan Akun & kata sandi pengguna </p>
			</div>
		</div>

		<div class="col-xl-9 col-lg-8 col-md-12 col-12">
			<div class="card">
				<div class="card-body">
					<div class="mb-6">
						<h4 class="mb-1">Akun Pengguna</h4>
					</div>
					<form>
						<!-- row -->
						<div class="mb-3 row">
							<label for="username" class="col-sm-4 col-form-label form-label">Nama Pengguna</label>
							<div class="col-md-8 col-12">
								<input type="hidden" name="id_user" class="form-control" value="<?= set_value('id_user', isset($data->id_user) ? $data->id_user : ''); ?>">
								<input type="text" name="username" <?= isset($data->username) ? 'readonly' : ''; ?> class="form-control" id="username" placeholder="Username" aria-describedby="textHelp" value="<?= set_value('username', isset($data->username) ? $data->username : ''); ?>">
								<!-- <div id="textHelp" class="form-text">We'll never share your texts with anyone else.</div> -->
							</div>
						</div>
						<div class="mb-3 row">
							<label for="password" class="col-sm-4 col-form-label form-label">Kata Sandi</label>
							<div class="col-md-8 col-12">
								<input type="password" name="password" class="form-control text-dark-10" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" id="password" aria-describedby="textHelp" value="">
								<!-- <div id="textHelp" class="form-text">We'll never share your texts with anyone else.</div> -->
							</div>
						</div>
						<div class="mb-3 row">
							<label for="full_name" class="col-sm-4 col-form-label form-label">Konfirmasi Sandi</label>
							<div class="col-md-8 col-12">
								<input type="password" name="re-password" class="form-control text-dark-10" id="re-password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" aria-describedby="textHelp">
								<!-- <div id="textHelp" class="form-text">We'll never share your texts with anyone else.</div> -->
							</div>
						</div>

						<!-- row -->
						<div class="row align-items-center">
							<div class="offset-md-4 col-md-8 mt-4">
								<button id="save_account" type="button" class="btn btn-danger"><i data-feather="save" width="18px"></i> Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
</form>
</div><!-- /.box -->

<!-- page script -->
<script type="text/javascript">
	function preview_image(event) {
		var reader = new FileReader();
		reader.onload = function() {
			var output = document.getElementById('preview');
			output.src = reader.result;
		}
		reader.readAsDataURL(event.target.files[0]);
	}

	$(document).on('change', '#status', function() {
		let status = $(this).is(':checked');

		if (status) {
			$('#status').val('Y')
			$('.cek_status').text('Aktif')
		} else {
			$('#status').val('N')
			$('.cek_status').text('Tidak Aktif')
		}
	})

	$(document).on('click', '#save_user', function() {
		let formdata = new FormData($('#frm_users')[0]);

		$.ajax({
			url: siteurl + controller + 'setting/save',
			data: formdata,
			type: "POST",
			dataType: 'JSON',
			contentType: false,
			processData: false,
			cache: false,
			success: function(result) {
				console.log(result);
				if (result.status == 1) {
					Swal.fire({
						title: 'Success!',
						text: result.msg,
						icon: 'success',
						timer: 3000
					}).then(function() {
						location.reload();
					})

				} else {
					Swal.fire({
						title: 'Perhatian!',
						html: result.msg,
						icon: 'warning',
						timer: 5000
					})
				}
			},
			error: function(result) {
				Swal.fire({
					title: 'Error!',
					text: 'Server timeout',
					icon: 'error',
					timer: 5000
				})
			}

		})
	})

	$(document).on('click', '#save_account', function() {
		let formdata = new FormData($('#frm_account')[0]);

		$.ajax({
			url: siteurl + controller + 'setting/save_account',
			data: formdata,
			type: "POST",
			dataType: 'JSON',
			contentType: false,
			processData: false,
			cache: false,
			success: function(result) {
				console.log(result);
				if (result.status == 1) {
					Swal.fire({
						title: 'Success!',
						text: result.msg,
						icon: 'success',
						timer: 3000
					}).then(function() {
						location.reload();
					})

				} else {
					Swal.fire({
						title: 'Perringatan',
						html: result.msg,
						icon: 'warning',
						timer: 5000
					})
				}
			},
			error: function(result) {
				Swal.fire({
					title: 'Error!',
					text: 'Server timeout',
					icon: 'error',
					timer: 5000
				})
			}

		})
	})
</script>