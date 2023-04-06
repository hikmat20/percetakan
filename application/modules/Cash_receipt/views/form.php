 <div class="d-flex justify-content-between">
     <h3 class="card-title"><?= $title; ?></h3>
 </div>
 <div class="card">
     <div class="card-body">
         <form id="form-cash-receipt">
             <div class="row mb-3">
                 <div class="col-md-3 col-sm-12">
                     <label for="" class="form-label fw-bold text-secondary">Karyawan</label>
                 </div>
                 <div class=" col-md-12 col-sm-12">
                     <input type="hidden" name="id" class="form-control" value="<?= isset($cash_receipt) ? $cash_receipt->id : ''; ?>">
                     <?php if (isset($cash_receipt)) : ?>
                         <input type="hidden" readonly id="employee" name="employee_id" class="form-control" value="<?= isset($cash_receipt) ? $cash_receipt->employee_id : ''; ?>">
                         <input type="text" readonly class="form-control" value="<?= isset($cash_receipt) ? $cash_receipt->employee_name : ''; ?>">
                     <?php else : ?>
                         <select name="employee_id" id="employee" class="form-control select" data-allow-clear="true" data-placeholder="~ Pilih ~">
                             <option value=""></option>
                             <?php foreach ($employees as $emp) : ?>
                                 <option value="<?= $emp->id; ?>"><?= $emp->employee_name; ?></option>
                             <?php endforeach; ?>
                         </select>
                     <?php endif; ?>
                     <small class="form-text text-danger invalid-feedback">Pilih nama Karyawan</small>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-12">
                     <label for="" class="form-label fw-bold text-secondary">Tanggal</label>
                 </div>
                 <div class="col-md-12">
                     <input type="date" name="date" id="date" class="form-control" value="<?= isset($cash_receipt) ? $cash_receipt->date : ''; ?>">
                     <small class="form-text text-danger invalid-feedback">Pilih nama Karyawan</small>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-12">
                     <label for="" class="form-label fw-bold text-secondary">Jumlah Kasbon</label>
                 </div>
                 <div class="col-md-12">
                     <div class="input-group">
                         <span class="input-group-text">Rp</span>
                         <input name="cash_value" id="cash_value" class="form-control text-end numeric currency" value="<?= isset($cash_receipt) ? number_format($cash_receipt->cash_value) : '';; ?>" autocomplete="off" placeholder="0">
                         <small class="form-text text-danger invalid-feedback">Isi jumlah nominal kasbon</small>
                     </div>
                 </div>
             </div>
             <div class="row mb-3">
                 <div class="col-md-12">
                     <label for="" class="form-label fw-bold text-secondary">Keperluan</label>
                 </div>
                 <div class="col-md-12">
                     <textarea name="description" class="form-control" placeholder="Keperluan"><?= isset($cash_receipt) ? $cash_receipt->description : '';; ?></textarea>
                 </div>
             </div>
             <hr>
             <div class="row mb-3">
                 <div class="col-md-12">
                 </div>
                 <div class="col-md-12">
                     <button type="button" class="btn btn-primary" id="saveCashReceipt"><i class="fa fa-save"></i> Simpan</button>
                     <a href="<?= base_url('cash_receipt'); ?>" class="btn btn-danger"><i class="fa fa-reply"></i> Kembali</a>
                 </div>
             </div>
         </form>

     </div>
 </div>

 <script>
     $(document).ready(function() {
         $('.select').select2({
             dropdownParent: $('#dataView'),
             theme: "bootstrap-5",
             placeholder: '~ Pilih ~',
             width: '100%',
             allowClear: true,
         })

         $(document).on('click', '#saveCashReceipt', function() {
             valid = true;
             let employee = $('#employee').val();
             let date = $('#date').val();
             let value = $('#cash_value').val();
             $('#employee').removeClass('is-invalid')
             $('#date').removeClass('is-invalid')
             $('#cash_value').removeClass('is-invalid')

             if (!employee) {
                 $('#employee').addClass('is-invalid')
                 valid = false;
             }
             if (!date) {
                 $('#date').addClass('is-invalid')
                 valid = false;
             }
             if (!value) {
                 $('#cash_value').addClass('is-invalid')
                 valid = false;
             }

             if (valid == true) {
                 let formdata = new FormData($('#form-cash-receipt')[0])

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