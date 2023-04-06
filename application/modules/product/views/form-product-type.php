 <div class="d-flex justify-content-between mb-3">
     <h3 class="card-title">Input Kategori Baru</h3>
 </div>

 <form id="form-product-type" enctype="multipart/form-data">
     <div class="card mb-2">
         <div class="card-body">
             <fieldset class="form-group row mb-5">
                 <h4 class="col-sm-12 fw-bold">Informasi Jenis Produk</h4>
             </fieldset>
             <div class="form-group row mb-6">
                 <div class="col-md-3">
                     <label for="nama" class="fw-bold">Kategori <small class="text-danger">*</small></label>
                     <p><small>Pilih kategori produk</small></p>
                 </div>
                 <div class="col-md-5">
                     <input type="hidden" id="id" name="id" placeholder="ID" value="<?= (isset($product_type)) ? $product_type->id : ''; ?>">
                     <select name="category_id" id="category_id" class="form-select select">
                         <option value=""></option>
                         <?php foreach ($category as $cat) : ?>
                             <option value="<?= $cat->code; ?>" <?= (((isset($product_type)) ? $product_type->category_id : '') ==  $cat->code) ? 'selected' : ''; ?>><?= $cat->name; ?></option>
                         <?php endforeach; ?>
                     </select>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <div class="col-md-3">
                     <label for="nama" class="fw-bold">Nama Jenis Produk <small class="text-danger">*</small></label>
                     <p><small>Nama kategori max. 40 karakter.</small></p>
                 </div>
                 <div class="col-md-5">
                     <input type="text" class="form-control" name="name" id="name" placeholder="Nama Jenis Produk" value="<?= (isset($product_type)) ? $product_type->name : ''; ?>">
                     <small class="invalid-feedback">Nama tidak boleh kosong.!</small>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Status</label>
                 <div class="col-md-5">
                     <div class="form-check form-switch">
                         <input class="form-check-input" name="active" type="checkbox" value="Y" id="status" <?= (isset($product_type) && $product_type->active == 'Y') ? 'checked' : ''; ?>>
                         <label class="form-check-label" for="status">Aktif</label>
                     </div>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Finishing</label>
                 <div class="col-md-5">
                     <div class="form-check form-switch">
                         <input class="form-check-input" value="Y" name="flag_finishing" type="checkbox" id="finishing" <?= (isset($product_type) && $product_type->flag_finishing == 'Y') ? 'checked' : ''; ?>>
                         <label class="form-check-label" for="finishing"> Ya</label>
                     </div>
                     <div id="input_finishing">
                         <table class="table table-hover table-borderless table-sm" id="table_finishing">
                             <thead>
                                 <tr>
                                     <td>Nama Finishing</td>
                                     <td>Opsi</td>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if (isset($finishing)) :
                                        $n = 0;
                                        foreach ($finishing as $fin) : $n++; ?>
                                         <tr>
                                             <td>
                                                 <input type="hidden" class="form-control form-control-sm" name="finishing[<?= $n; ?>][id]" placeholder="ID" value="<?= $fin->id; ?>">
                                                 <input type="text" class="form-control form-control-sm" name="finishing[<?= $n; ?>][finishing_name]" placeholder="Finishing" value="<?= $fin->name; ?>">
                                             </td>
                                             <td><button type="button" class="btn btn-sm btn-default text-danger del_fin" data-id="<?= $fin->id; ?>"><i class="fa fa-times"></i></button></td>
                                         </tr>
                                 <?php endforeach;
                                    endif; ?>
                             </tbody>
                         </table>
                         <div class="card-footer bg-white">
                             <button type="button" id="add_finishing" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Finishing</button>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Gambar</label>
                 <div class="col-md-5">
                     <?php $image = (isset($product_type->image) && $product_type->image !== '') ? $product_type->image : 'blank.png'; ?>
                     <img src="<?= base_url("assets/products/$image"); ?>" id="preview" class="img-thumbnail" width="200" alt="Gambar Jenis Produk">
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold"></label>
                 <div class="col-md-5">
                     <button type="button" class="btn btn-sm btn-warning" title="Upload Gambar" onclick="$('#gambar').click()"><i data-feather="upload"></i> Pilih Gambar</button>
                     <button type="button" class="btn btn-sm btn-danger" title="Hapus Gambar" onclick="remove_image()"><i data-feather="trash"></i></button>
                     <input type="hidden" name="old_photo" id="old_photo" value="<?= (isset($product_type->image)) ? $product_type->image : ''; ?>">
                     <input type="file" name="gambar" id="gambar" class="d-none" onchange="preview_image(event)">
                 </div>
             </div>
             <hr>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold"></label>
                 <div class="col-md-5">
                     <button type="button" id="save" class="btn btn-primary mr-3"><i data-feather="save"></i> Simpan</button>
                     <a href="<?= base_url('product-type'); ?>" class="btn btn-danger"><i data-feather="corner-down-left"></i> Kembali</a>
                 </div>
             </div>
         </div>
     </div>
 </form>

 <script>
     function preview_image(event) {
         var reader = new FileReader();
         reader.onload = function() {
             var output = document.getElementById('preview');
             output.src = reader.result;
         }
         reader.readAsDataURL(event.target.files[0]);
     }

     function remove_image() {
         let id = $('#id').val();

         Swal.fire({
             title: 'Konfirmasi',
             html: 'Gambar yang sudah dihapus tidak bisa dikembalikan lagi! <i class="fa fa-trash"></i>',
             icon: 'question',
             showCancelButton: true,
             cancelButtonText: 'Batal',
             confirmButtonText: 'Ya, Hapus'
         }).then((value) => {
             if (value.isConfirmed == true) {
                 $.ajax({
                     url: siteurl + 'product/delete_image',
                     type: 'POST',
                     dataType: 'JSON',
                     data: {
                         id
                     },
                     success: function(result) {
                         if (result.status == 1) {
                             Swal.fire({
                                 title: 'Berhasil!',
                                 text: result.msg,
                                 icon: 'success',
                                 timer: 1500
                             }).then(function() {
                                 let gambar = $('#gambar')
                                 $('#preview').attr('src', siteurl + 'assets/products/blank.png');
                                 gambar.replaceWith(gambar.val('').clone(true));
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
                             text: 'Server timeout',
                             icon: 'error',
                             timer: 3000
                         })
                     }
                 })
             }
         })

     }

     $(document).on('click', '#save', function() {
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

         let formdata = new FormData($('#form-product-type')[0])
         $.ajax({
             url: siteurl + 'product/save_product_type',
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
                         location.href = siteurl + 'product-type'
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

     //  INPUT DATA FINISHING
     $(document).on('change', '#finishing', function() {
         let cek = $(this).is(':checked')
         $('#input_finishing').text('')
         if (cek) {
             $('#input_finishing').load(siteurl + 'product/finishing')

         }
     })

     $(document).on('click', '#add_finishing', function() {
         let n = 0
         let html = '';
         n = $('#table_finishing tbody tr').length + 1
         html = `
         <tr>
            <td><input type="text" class="form-control form-control-sm" name="finishing[` + n + `][finishing_name]" placeholder="Cth : Laminating"></td>
            <td><button type="button" class="btn btn-sm text-danger btn-default del_fin" data-id=""><i class="fa fa-times"></i></button></td>
            </tr>`;
         $('#table_finishing tbody').append(html)
     })

     $(document).on('click', '.del_fin', function() {
         let id = $(this).data('id');
         console.log(id);
         if (id != '') {
             Swal.fire({
                 title: 'Konfirmasi',
                 html: 'Finishing yang sudah di hapus tidak bisa dikebalikan lagi! <i class="fa fa-trash"></i>',
                 icon: 'question',
                 showCancelButton: true,
                 cancelButtonText: 'Batal',
                 confirmButtonText: 'Ya, Hapus'
             }).then((value) => {
                 if (value.isConfirmed == true) {
                     $.ajax({
                         url: siteurl + 'product/delete_finishing',
                         type: 'POST',
                         dataType: 'JSON',
                         data: {
                             id
                         },
                         success: function(result) {
                             if (result.status == 1) {
                                 Swal.fire({
                                     title: 'Berhasil!',
                                     text: result.msg,
                                     icon: 'success',
                                     timer: 1500
                                 }).then(function() {
                                     location.reload();
                                 })
                                 $(this).parents('tr').remove();
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
                                 text: 'Server timeout',
                                 icon: 'error',
                                 timer: 3000
                             })
                         }
                     })
                 }
             })
         } else {
             $(this).parents('tr').remove();
         }
     })
 </script>