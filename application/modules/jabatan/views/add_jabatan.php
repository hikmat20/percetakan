<div class="nav-tabs-custom">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs-custom nav-tabs" role="tablist">
		<li role="presentation" class="active">
			<a href="#home" aria-controls="home" role="tab" data-toggle="tab">Jabatan</a>
		</li>
		<li role="presentation">
			<a href="#tab" aria-controls="tab" role="tab" data-toggle="tab">Jabatan User</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="home">

			<form action="#" method="POST" id="form_proses_bro">
				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title"><?= $title; ?></h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class='form-group row'>
							<label class='label-control col-sm-2'><b>Nama Jabatan<span class='text-red'>*</span></b></label>
							<div class='col-sm-4'>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calculator"></i></span>
									<?php
									echo form_input(array('id' => 'nm_jabatan', 'name' => 'nm_jabatan', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Nama Jabatan'));
									?>
								</div>

							</div>
						</div>
					</div>
					<div class='box-footer'>
						<?php
						echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-primary', 'value' => 'save', 'content' => 'Save', 'id' => 'simpan-com')) . ' ';
						echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-danger', 'value' => 'back', 'content' => 'Back', 'onClick' => 'javascript:back()'));
						?>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</form>

		</div>
		<div role="tabpanel" class="tab-pane" id="tab">
			<div class="box box-solid">
				<div class="box-header">
					<h3 class="box-title">User Jabatan</h3>
				</div>
				<div class="box-body">
					<form id="form-user-jabatan" class="form-horizontal">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="col-md-3">Select Jabatan</label>
									<div class="col-md-8">
										<select name="jabatan" id="jabatan" class="form-control select2">
											<option value="">-- Pilih Jabatan --</option>
											<?php foreach ($jabatan as $jbt) : ?>
												<option value="<?= $jbt->id; ?>"><?= $jbt->nm_jabatan; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="col-md-3">Select Jabatan</label>
									<div class="col-md-8">
										<select name="user" id="user" class="form-control select2">
											<option value="">-- Pilih User --</option>
											<?php foreach ($users as $usr) : ?>
												<option value="<?= $usr->id_user; ?>"><?= $usr->nm_lengkap; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="box-footer">
					<button type="button" class="btn btn-primary" id="save-pejabat"><i class="fa fa-save"></i> Save</button>
					<button type="button" class="btn btn-danger" onclick="history.go(-1)"><i class="fa fa-reply"></i> Back</button>
				</div>
			</div>
			<div class="box box-solid">
				<div class="box-header">
					<h3 class="box-title">List</h3>
				</div>
				<div class="box-body" id="data"></div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('.select2').select2({
				width: '100%'
			});
			DataJabatan();

			$('#simpan-com').click(function(e) {
				e.preventDefault();
				var nama_master = $('#nm_jabatan').val();
				if (nama_master == '' || nama_master == null) {
					swal({
						title: "Error Message!",
						text: 'Empty Nama Jabatan, please input Nama Jabatan  first.....',
						type: "warning"
					});
					return false;
				}
				swal({
						title: "Are you sure?",
						text: "You will not be able to process again this data!",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-danger",
						confirmButtonText: "Yes, Process it!",
						cancelButtonText: "No, cancel process!",
						closeOnConfirm: true,
						closeOnCancel: false
					},
					function(isConfirm) {
						if (isConfirm) {
							var formData = new FormData($('#form_proses_bro')[0]);
							var baseurl = base_url + active_controller + '/add';
							$.ajax({
								url: baseurl,
								type: "POST",
								data: formData,
								cache: false,
								dataType: 'json',
								processData: false,
								contentType: false,
								success: function(data) {
									if (data.status == 1) {
										swal({
											title: "Save Success!",
											text: data.pesan,
											type: "success",
											timer: 7000,
											showCancelButton: false,
											showConfirmButton: false,
											allowOutsideClick: false
										});
										window.location.href = base_url + active_controller;
									} else {

										if (data.status == 2) {
											swal({
												title: "Save Failed!",
												text: data.pesan,
												type: "warning",
												timer: 7000,
												showCancelButton: false,
												showConfirmButton: false,
												allowOutsideClick: false
											});
										} else {
											swal({
												title: "Save Failed!",
												text: data.pesan,
												type: "warning",
												timer: 7000,
												showCancelButton: false,
												showConfirmButton: false,
												allowOutsideClick: false
											});
										}

									}
								},
								error: function() {

									swal({
										title: "Error Message !",
										text: 'An Error Occured During Process. Please try again..',
										type: "warning",
										timer: 7000,
										showCancelButton: false,
										showConfirmButton: false,
										allowOutsideClick: false
									});
								}
							});
						} else {
							swal("Cancelled", "Data can be process again :)", "error");
							return false;
						}
					});
			});

			$('#save-pejabat').click(function(e) {
				e.preventDefault();
				var jabatan = $('#jabatan').val();
				var user = $('#user').val();

				if (jabatan == '' || jabatan == null || user == '' || user == null) {
					swal({
						title: "Error Message!",
						text: 'Empty Nama Jabatan dan User, please input Nama Jabatan User first.....',
						type: "warning"
					});
					return false;
				}

				swal({
						title: "Are you sure?",
						text: "You will not be able to process again this data!",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-danger",
						confirmButtonText: "Yes, Process it!",
						cancelButtonText: "No, cancel process!",
						closeOnConfirm: true,
						closeOnCancel: false
					},
					function(isConfirm) {
						if (isConfirm) {
							var formData = new FormData($('#form-user-jabatan')[0]);
							var baseurl = base_url + active_controller + '/savePejabat';
							$.ajax({
								url: baseurl,
								type: "POST",
								data: formData,
								cache: false,
								dataType: 'json',
								processData: false,
								contentType: false,
								success: function(data) {
									if (data.status == 1) {
										swal({
											title: "Save Success!",
											text: data.pesan,
											type: "success",
											timer: 3000,
											showCancelButton: false,
											showConfirmButton: false,
											allowOutsideClick: false
										}, function() {
											window.location.reload();
											DataDetail();
										});

									} else {

										if (data.status == 2) {
											swal({
												title: "Save Failed!",
												text: data.pesan,
												type: "warning",
												timer: 3000,
												showCancelButton: false,
												showConfirmButton: false,
												allowOutsideClick: false
											});
										} else {
											swal({
												title: "Save Failed!",
												text: data.pesan,
												type: "warning",
												timer: 3000,
												showCancelButton: false,
												showConfirmButton: false,
												allowOutsideClick: false
											});
										}

									}
								},
								error: function() {

									swal({
										title: "Error Message !",
										text: 'An Error Occured During Process. Please try again..',
										type: "warning",
										timer: 3000,
										showCancelButton: false,
										showConfirmButton: false,
										allowOutsideClick: false
									});
								}
							});
						} else {
							swal("Cancelled", "Data can be process again :)", "error");
							return false;
						}
					});
			});

			$(document).on('change', '#jabatan', function() {
				DataJabatan();
			})
		});

		function DataJabatan() {
			var id_jbt = $("#jabatan").val();
			$.ajax({
				type: "POST",
				url: siteurl + active_controller + "load_jabatan",
				data: {
					id_jbt
				},
				success: function(data) {
					$("#data").html(data);
					$("#loading").fadeOut(100);
					$("#data").fadeIn(500);
				}
			});
		}
	</script>