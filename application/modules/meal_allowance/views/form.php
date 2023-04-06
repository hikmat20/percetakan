 <div class="d-flex justify-content-between">
     <h3 class="card-title"><?= $title; ?></h3>
 </div>
 <div class="card">
     <div class="card-body">
         <form id="form-meal">
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Karyawan</label>
                 </div>
                 <div class="col-md-4">
                     <input type="hidden" name="id" class="form-control" value="<?= (isset($meal->id)) ? $meal->id : ''; ?>">
                     <select name="employee_id" id="employee" class="form-control select" <?= (isset($meal->id)) ? 'disabled' : '';; ?> data-allow-clear="true" data-placeholder="~ Pilih ~">
                         <option value=""></option>
                         <?php foreach ($employees as $emp) : ?>
                             <option value="<?= $emp->id; ?>" <?= (isset($meal->id) && $meal->employee_id ==  $emp->id) ? 'selected' : '';; ?>><?= $emp->employee_name; ?></option>
                         <?php endforeach; ?>
                     </select>
                     <small class="form-text text-danger invalid-feedback">Pilih nama Karyawan</small>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Tanggal</label>
                 </div>
                 <div class="col-md-4">
                     <input type="date" name="date" id="date" class="form-control" value="<?= (isset($meal->date)) ? $meal->date : date('Y-m-d'); ?>">
                     <small class="form-text text-danger invalid-feedback">Pilih tanggal input</small>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-2">
                     <label for="" class="form-label fw-bold text-secondary">Jumlah Uang Makan</label>
                 </div>
                 <div class="col-md-4">
                     <div class="input-group">
                         <span class="input-group-text">Rp</span>
                         <input name="total_value" id="total_value" value="<?= (isset($meal->total_value)) ? number_format($meal->total_value) : ''; ?>" class="form-control text-end numeric currency" autocomplete="off" placeholder="0">
                         <small class="form-text text-danger invalid-feedback">Isi jumlah nominal Uang Makan</small>
                     </div>
                 </div>
             </div>
             <hr>
             <div class="row mb-3">
                 <div class="col-md-2">
                 </div>
                 <div class="col-md-4">
                     <button type="button" class="btn btn-primary" id="saveMeal"><i class="fa fa-save"></i> Simpan</button>
                     <a href="<?= base_url('meal_allowance'); ?>" class="btn btn-danger"><i class="fa fa-reply"></i> Kembali</a>
                 </div>
             </div>
         </form>

     </div>
 </div>

 <script>
     $(document).ready(function() {
         $(document).on('click', '#saveMeal', function() {
             valid = true;
             let employee = $('#employee').val();
             let date = $('#date').val();
             let value = $('#total_value').val();
             $('#employee').removeClass('is-invalid')
             $('#date').removeClass('is-invalid')
             $('#total_value').removeClass('is-invalid')

             if (!employee) {
                 $('#employee').addClass('is-invalid')
                 valid = false;
             }
             if (!date) {
                 $('#date').addClass('is-invalid')
                 valid = false;
             }
             if (!value) {
                 $('#total_value').addClass('is-invalid')
                 valid = false;
             }

             if (valid == true) {
                 let formdata = new FormData($('#form-meal')[0])

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