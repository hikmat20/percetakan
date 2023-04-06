 <div class="d-flex justify-content-between">
     <h3 class="card-title"><?= $title; ?></h3>
 </div>
 <div class="card">
     <div class="card-body">
         <form id="form-employee">
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Nama Karyawan</label>
                 </div>
                 <div class="col-md-4">
                     <input type="hidden" name="id" class="form-control" value="<?= (isset($employee->id)) ? $employee->id : ''; ?>">
                     <input type="text" name="employee_name" id="employee_name" placeholder="Nama Karyawan" class="form-control" value="<?= (isset($employee->employee_name)) ? $employee->employee_name : ''; ?>">
                     <small class="form-text text-danger invalid-feedback">Input nama Karyawan</small>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Tanggal Rekrut</label>
                 </div>
                 <div class="col-md-4">
                     <input type="date" name="hire_date" id="hire_date" class="form-control" value="<?= (isset($employee->hire_date)) ? $employee->hire_date : date('Y-m-d'); ?>">
                     <small class="form-text text-danger invalid-feedback">Pilih tanggal Rekrut karyawan</small>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Telepon</label>
                 </div>
                 <div class="col-md-4">
                     <div class="input-group">
                         <input name="phone" id="phone" value="<?= (isset($employee->phone)) ? ($employee->phone) : ''; ?>" class="form-control" autocomplete="off" placeholder="0812...">
                         <small class="form-text text-danger invalid-feedback">Isi nomor telepon karyawan</small>
                     </div>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Gaji Pokok /Bulan</label>
                 </div>
                 <div class="col-md-4">
                     <div class="input-group">
                         <input name="monthly_salary" id="monthly_salary" value="<?= (isset($employee->monthly_salary)) ? number_format($employee->monthly_salary) : ''; ?>" class="form-control currency" autocomplete="off" placeholder="0">
                         <small class="form-text text-danger invalid-feedback">Isi nomor telepon karyawan</small>
                     </div>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Jatah Libur /Bulan</label>
                 </div>
                 <div class="col-md-4">
                     <div class="input-group">
                         <input name="leave_allowance" id="leave_allowance" value="<?= (isset($employee->leave_allowance)) ? number_format($employee->leave_allowance) : ''; ?>" class="form-control currency" autocomplete="off" placeholder="0">
                         <small class="form-text text-danger invalid-feedback">Jatah libur karyawan</small>
                     </div>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Alamat</label>
                 </div>
                 <div class="col-md-4">
                     <div class="input-group">
                         <textarea name="address" id="address" class="form-control" autocomplete="off" placeholder="Alamat"><?= (isset($employee->address)) ? ($employee->address) : ''; ?></textarea>
                         <small class="form-text text-danger invalid-feedback">Isi nomor telepon karyawan</small>
                     </div>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Bagian</label>
                 </div>
                 <div class="col-md-4">
                     <select name="position" id="position" class="form-control select" data-allow-clear="true" data-placeholder="~ Pilih ~">
                         <option value=""></option>
                         <?php foreach ($positions as $pos) : ?>
                             <option value="<?= $pos->id; ?>" <?= (isset($employee->id) && $employee->position ==  $pos->id) ? 'selected' : ''; ?>><?= $pos->position_name; ?></option>
                         <?php endforeach; ?>
                     </select>
                     <small class="form-text text-danger invalid-feedback">Input nama Karyawan</small>
                 </div>
             </div>
             <hr>
             <div class="row mb-3">
                 <div class="col-md-2">
                 </div>
                 <div class="col-md-4">
                     <button type="button" class="btn btn-primary" id="save"><i class="fa fa-save"></i> Simpan</button>
                     <a href="<?= base_url('employees'); ?>" class="btn btn-danger"><i class="fa fa-reply"></i> Kembali</a>
                 </div>
             </div>
         </form>

     </div>
 </div>

 <script>
     $(document).ready(function() {
         $(document).on('click', '#save', function() {
             valid = true;
             let employee_name = $('#employee_name').val();
             let hire_date = $('#hire_date').val();
             let phone = $('#phone').val();
             let position = $('#position').val();

             $('#employee_name').removeClass('is-invalid')
             $('#hire_date').removeClass('is-invalid')
             $('#phone').removeClass('is-invalid')
             $('#position').removeClass('is-invalid')

             if (!employee_name) {
                 $('#employee_name').addClass('is-invalid')
                 valid = false;
             }
             if (!hire_date) {
                 $('#hire_date').addClass('is-invalid')
                 valid = false;
             }
             if (!phone) {
                 $('#phone').addClass('is-invalid')
                 valid = false;
             }
             if (!position) {
                 $('#position').addClass('is-invalid')
                 valid = false;
             }

             if (valid == true) {
                 let formdata = new FormData($('#form-employee')[0])
                 $.ajax({
                     url: siteurl + controller + 'save',
                     type: 'POST',
                     data: formdata,
                     dataType: "JSON",
                     contentType: false,
                     processData: false,
                     cache: false,
                     success: function(result) {
                         if (result.status == 1) {
                             Swal.fire({
                                 title: 'Berhasil',
                                 text: result.msg,
                                 icon: 'success',
                                 timer: 3000
                             }).then(() => {
                                 location.href = siteurl + controller
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
                             text: 'Error. Server timeout..',
                             icon: 'error',
                             timer: 3000
                         })
                     }
                 })
             }




         })
     })
 </script>