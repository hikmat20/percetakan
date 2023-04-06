 <div class="d-flex justify-content-between mb-3">
     <h3 class="card-title">Input Kategori Baru</h3>
 </div>

 <form id="form-category">
     <div class="card mb-2">
         <div class="card-body">
             <fieldset class="form-group row mb-5">
                 <h4 class="col-sm-12 fw-bold">Informasi Kategori</h4>
             </fieldset>
             <div class="form-group row mb-6">
                 <div class="col-md-3">
                     <label for="nama" class="fw-bold">Kode <small class="text-danger">*</small></label>
                     <p><small>Kode kategori max. 3 karakter.</small></p>
                 </div>
                 <div class="col-md-5">
                     <input type="hidden" name="type" placeholder="Kode Kategori" value="<?= (isset($category)) ? 'update' : 'add'; ?>">
                     <input type="text" autocapitalize="characters" <?= (isset($category)) ? 'readonly' : ''; ?> maxlength="3" class="form-control" style="width: 150px;" name="code" id="code" placeholder="Kode Kategori" value="<?= (isset($category)) ? $category->code : ''; ?>">
                     <small class="invalid-feedback">Kode tidak boleh kosong.!</small>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <div class="col-md-3">
                     <label for="nama" class="fw-bold">Nama Kategori <small class="text-danger">*</small></label>
                     <p><small>Nama kategori max. 40 karakter.</small></p>
                 </div>
                 <div class="col-md-5">
                     <input type="text" class="form-control" name="name" id="name" placeholder="Nama Kategori" value="<?= (isset($category)) ? $category->name : ''; ?>">
                     <small class="invalid-feedback">Nama tidak boleh kosong.!</small>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold"></label>
                 <div class="col-md-5">
                     <button type="button" id="saveCategory" class="btn btn-primary mr-3"><i data-feather="save"></i> Simpan</button>
                     <a href="<?= base_url('products-category'); ?>" class="btn btn-danger"><i data-feather="corner-down-left"></i> Kembali</a>
                 </div>
             </div>
         </div>
     </div>
 </form>

 <script>
     $(document).on('click', '#saveCategory', function() {
         $('#name').removeClass('is-invalid');
         $('#code').removeClass('is-invalid');
         //  $('.name').addClass('d-none');
         let code = $('#code').val();
         let name = $('#name').val();
         if (!code) {
             Swal.fire({
                 title: 'Peringatan',
                 text: 'Data belum lengkap, mohon dilengkapi.',
                 icon: 'warning',
                 timer: 1500,
             })
             $('#code').addClass('is-invalid');
         }

         if (!name) {
             Swal.fire({
                 title: 'Peringatan',
                 text: 'Data belum lengkap, mohon dilengkapi.',
                 icon: 'warning',
                 timer: 1500,
             })
             $('#name').addClass('is-invalid');
             return false
         }

         let formdata = new FormData($('#form-category')[0])
         $.ajax({
             url: siteurl + 'product/save_category',
             data: formdata,
             processData: false,
             contentType: false,
             async: false,
             type: 'POST',
             dataType: 'JSON',
             success: function(result) {
                 if (result.status == '1') {
                     Swal.fire({
                         title: 'Berhasil!',
                         text: result.msg,
                         icon: 'success',
                         timer: 1500,
                     }).then(function() {
                         location.href = siteurl + 'products-category'
                     })
                 } else if (result.status == '2') {
                     Swal.fire({
                         title: 'Perhatian!',
                         text: result.msg,
                         icon: 'warning',
                         timer: 3000,
                     })
                 } else {
                     Swal.fire({
                         title: 'Error!',
                         text: result.msg,
                         icon: 'error',
                         timer: 1500,
                     })
                 }
             },
             error: function(result) {
                 Swal.fire({
                     title: 'Error',
                     text: 'Terjadi kesalahan!. Server time out.',
                     icon: 'error',
                     timer: 1500,
                 })
             }
         })
     })
 </script>