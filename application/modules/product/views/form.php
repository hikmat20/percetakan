 <div class="d-flex justify-content-between mb-3">
     <h3 class="card-title">Input Produk Baru</h3>
 </div>

 <form id="form-product">
     <div class="card mb-2">
         <div class="card-body">
             <fieldset class="form-group row mb-5">
                 <h4 class="col-sm-12 fw-bold">Informasi Produk</h4>
             </fieldset>
             <div class="form-group row mb-6">
                 <div class="col-md-3">
                     <label for="nama" class="fw-bold">Kategori Produk</label>
                     <p><small>Pilih Jenis kategori produk terlebih dahulu.</small></p>
                 </div>
                 <div class="col-md-5">
                     <div class="mb-2">

                         <select name="category_id" id="category" class="form-select select">
                             <option value="">~ Pilih ~</option>
                             <?php foreach ($category as $cat) : ?>
                                 <option value="<?= $cat->code; ?>" <?= (isset($products_details) && $products_details->category_id == $cat->code) ? 'selected' : ''; ?>><?= $cat->name; ?></option>
                             <?php endforeach; ?>
                         </select>
                     </div>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <div class="col-md-3">
                     <label for="nama" class="fw-bold">Jenis Produk</label>
                     <p><small>Pilih Jenis jasa terlebih dahulu.</small></p>
                 </div>
                 <div class="col-md-5">
                     <div class="mb-2">
                         <select name="product_id" id="products" class="form-select select">
                             <option value="">~ Pilih ~</option>
                             <?php if (isset($products)) :
                                    foreach ($products as $pro) : ?>
                                     <option value="<?= $pro->id; ?>" <?= ($pro->id == $products_details->product_id) ? 'selected' : ''; ?>><?= $pro->name; ?></option>
                                 <?php endforeach; ?>
                             <?php endif; ?>
                         </select>
                     </div>
                     <!-- <button class="btn btn-primary btn-sm" type="button" id="add_products"><i data-feather="plus"></i> Tambah Jasa</button> -->
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <div class="col-md-3">
                     <label for="nama" class="fw-bold">Nama Produk</label>
                     <p class="float-left"><small>Maksikal 40 karakter.</small></p>
                 </div>
                 <div class="col-md-5">
                     <?php if (!isset($copy)) : ?>
                         <input type="hidden" class="form-control" name="id" id="id" value="<?= (isset($products_details)) ? $products_details->id : ''; ?>">
                     <?php endif; ?>
                     <input type="text" class="form-control  fw-bold" name="name" id="name" placeholder="Contoh : Print Poster A3+" value="<?= (isset($products_details)) ? $products_details->name : ''; ?>">
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Satuan</label>
                 <div class="col-md-5">
                     <select name="unit" id="unit" class="form-control select">
                         <option value=""></option>
                         <?php foreach ($units as $unit) : ?>
                             <option value="<?= $unit->code; ?>" <?= (isset($products_details) && $products_details->unit == $unit->code) ? 'selected' : ''; ?>><?= $unit->code . " | " . $unit->name;; ?></option>
                         <?php endforeach; ?>
                     </select>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Minimal Order</label>
                 <div class="col-md-5">
                     <div class="input-group" style="width: 150px;">
                         <input name=" min_order" min="0" type="number" class="form-control currency numeric text-end" id="min_order" value="<?= (isset($products_details)) ? number_format($products_details->min_order) : ''; ?>" placeholder="0">
                         <div class="input-group-text"><span class="unit"><?= (isset($products_details)) ? $products_details->unit : '--'; ?></span></div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="card mb-2">
         <div class="card-body">
             <fieldset class="form-group row mb-5">
                 <h4 class="col-sm-12 fw-bold">Harga Produk</h4>
             </fieldset>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Harga Satuan</label>
                 <div class="col-md-5">
                     <div class="input-group w-1000px" style="width:250px;">
                         <div class="input-group-text">Rp.</div>
                         <input name="unit_price" type="text" class="form-control currency numeric text-end" id="unit_price" value="<?= (isset($products_details)) ? number_format($products_details->unit_price) : ''; ?>" placeholder="Contoh : <?= number_format(20000); ?>">
                     </div>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Harga Grosir</label>
                 <div class="col-md-5">
                     <div class="form-check form-switch">
                         <input class="form-check-input" name="wholesaler" type="checkbox" value="Y" id="wholesale_price" <?= (isset($products_details) && $products_details->wholesaler == 'Y') ? 'checked' : ''; ?>>
                         <label class="form-check-label" for="wholesale_price">Harga Grosir</label>
                     </div>
                     <div id="input_wholesale_price">
                         <?php if (isset($products_details) && $products_details->wholesaler == 'Y') : ?>
                             <div class="card mt-5">
                                 <table class="table table-hover table-borderless table-sm" id="table_wh_price">
                                     <thead>
                                         <tr>
                                             <td width="100">&ge;</td>
                                             <td>Harga</td>
                                             <td width="25">Opsi</td>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php $n = 0;
                                            foreach ($wh_price as $whp) : $n++; ?>
                                             <tr>
                                                 <td class="text-center">
                                                     <?php if (!isset($copy)) : ?>
                                                         <input type="hidden" class="form-control text-end form-control-sm" name="wh_price[<?= $n; ?>][id]" value="<?= $whp->id; ?>" placeholder=" 0">
                                                     <?php endif; ?>
                                                     <input type="text" class="form-control text-end form-control-sm" name="wh_price[<?= $n; ?>][qty_min]" value="<?= $whp->qty_min; ?>" placeholder=" 0">
                                                 </td>
                                                 <td><input type="text" class="form-control text-end form-control-sm currency numeric" name="wh_price[<?= $n; ?>][price]" value="<?= number_format($whp->price); ?>" placeholder=" 0"></td>
                                                 <td class="text-center"><button type="button" class="btn btn-sm text-danger del_price" data-id="<?= $whp->id; ?>"><i class="fa fa-times"></i></button></td>
                                             </tr>
                                         <?php endforeach; ?>
                                     </tbody>
                                 </table>
                                 <div class="card-footer bg-white">
                                     <button type="button" id="add_price" class="btn btn-primary btn-sm"><i data-feather="plus"></i>Tambah Harga</button>
                                 </div>
                             </div>
                         <?php endif; ?>
                     </div>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Harga Berdasarkan</label>
                 <div class="col-md-5">
                     <select name="based_price" id="based_price" class="form-control select" placeholder="Barhga berdasarkan">
                         <option value="">~ Pilih ~</option>
                         <option value="QTY" <?= (isset($products_details) && $products_details->based_price == 'QTY') ? 'selected' : ''; ?>>QTY</option>
                         <option value="UNIT" <?= (isset($products_details) && $products_details->based_price == 'UNIT') ? 'selected' : ''; ?>>UNIT</option>
                     </select>
                 </div>
             </div>
         </div>
     </div>

     <div class="card mb-2">
         <div class="card-body">
             <fieldset class="form-group row mb-5">
                 <h4 class="col-sm-12 fw-bold">Harga Modal</h4>
             </fieldset>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Input Harga Modal</label>
                 <div class="col-md-5">
                     <div class="card mt-5">
                         <table class="table table-hover table-borderless table-sm" id="table_cost_item">
                             <thead>
                                 <tr>
                                     <td width="25">No</td>
                                     <td>Item</td>
                                     <td width="150">Harga</td>
                                     <td width="25">Opsi</td>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $n = 0;
                                    if (isset($cost_price)) : foreach ($cost_price as $cost) : $n++; ?>
                                         <tr>
                                             <td>
                                                 <?php if (!isset($copy)) : ?>
                                                     <input type="hidden" class="form-control text-end form-control-sm" name="wh_price[<?= $n; ?>][id]" value="<?= $whp->id; ?>" placeholder=" 0">
                                                 <?php endif; ?>
                                                 <input type="text" class="form-control text-end form-control-sm" name="wh_price[<?= $n; ?>][qty_min]" value="<?= $whp->qty_min; ?>" placeholder=" 0">
                                             </td>
                                             <td>
                                                 <select name="cost_item[<?= $n; ?>][cost_id]" class="from-select select">
                                                     <option value=""></option>
                                                     <?php foreach ($cost_item as $ci) : ?>
                                                         <option value="<?= $ci->id; ?>"><?= $ci->item; ?></option>
                                                     <?php endforeach; ?>
                                                 </select>
                                             </td>
                                             <td>
                                                 <input type="text" class="form-control d-none form-control-sm" name="cost_item[<?= $n; ?>][name]" placeholder="0">
                                                 <input type="text" class="form-control text-end form-control-sm currency numeric cost_price" name="wh_price[<?= $n; ?>][cost_value]" value="<?= number_format($whp->price); ?>" placeholder=" 0">
                                             </td>
                                             <td><button type="button" class="btn btn-sm text-danger del_cost" data-id="<?= $whp->id; ?>"><i class="fa fa-times"></i></button></td>
                                         </tr>
                                 <?php endforeach;
                                    endif; ?>
                             </tbody>
                         </table>
                         <div class="card-footer bg-white">
                             <div class="row">
                                 <div class="col-md-6">
                                     <button type="button" id="add_cost_item" class="btn btn-primary btn-sm"><i data-feather="plus"></i>Tambah Item</button>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="row">
                                         <label for="cost" class="col-md-4">Total</label>
                                         <div class="col-md-8">
                                             <input type="text" name="cost" id="cost" class="form-control form-control-sm text-end" readonly placeholder="0" aria-describedby="helpId">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="card mb-2">
         <div class="card-body">
             <fieldset class="form-group row mb-5">
                 <h4 class="col-sm-12 fw-bold">Rincian Produk</h4>
             </fieldset>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Status Produk</label>
                 <div class="col-md-5">
                     <div class="form-check form-switch">
                         <input class="form-check-input" name="active" type="checkbox" value="Y" id="status" <?= (isset($products_details) && $products_details->active == 'Y') ? 'checked' : ''; ?>>
                         <label class="form-check-label" for="status">Aktif</label>
                     </div>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Ukuran Custom</label>
                 <div class="col-md-5">
                     <div class="hstack gap-3">
                         <div class="form-check form-switch">
                             <input class="form-check-input" value="Y" name="flag_custom_size" type="checkbox" id="flag_custom_size" <?= (isset($products_details) && $products_details->flag_custom_size == 'Y') ? 'checked' : ''; ?>>
                             <label class="form-check-label" for="flag_custom_size"> Ya</label>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="form-group row mb-6">
                 <label for="nama" class="col-md-3 fw-bold">Finishing</label>
                 <div class="col-md-5">
                     <div class="form-check form-switch">
                         <input class="form-check-input" value="Y" name="flag_finishing" type="checkbox" id="finishing" <?= (isset($products_details) && $products_details->flag_finishing == 'Y') ? 'checked' : ''; ?>>
                         <label class="form-check-label" for="finishing"> Ya</label>
                     </div>
                     <div id="input_finishing"></div>
                 </div>
             </div>
             <hr>
             <div class="form-group row mb-6">
                 <div class="col-md-3">
                 </div>
                 <div class="col-md-5">
                     <button type="button" class="btn btn-primary mt-4" id="save"><i data-feather="save"></i> Simpan</button>
                     <a href="<?= base_url('product'); ?>" class="btn btn-danger mt-4"><i data-feather="corner-down-left"></i> Kembali</a>
                 </div>
             </div>

         </div>
     </div>
 </form>

 <!-- Modal -->
 <div class="modal fade" id="modalService" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Tamabah Jasa Baru</h5>
             </div>
             <div class="modal-body">
                 <div class="container-fluid">
                     <div class="container">
                         <div class="mb-3 row">
                             <label for="inputName" class="col-sm-1-12 col-form-label fw-bold">Nama Jasa</label>
                             <div class="col-sm-1-12">
                                 <input type="text" class="form-control required" name="service_name" placeholder="Cth: PRINT DIGITAL">
                                 <small class="msg_name invalid-feedback d-none">Nama jasa tidak boleh kosong</small>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-primary" id="save_service"><i data-feather="save"></i> Simpan</button>
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
             </div>
         </div>
     </div>
 </div>

 <script>
     $(document).ready(function() {
         $('.select').select2({
             theme: "bootstrap-5",
             placeholder: '~ Pilih ~',
             width: '100%',
             allowClear: true,
             selectionCssClass: "select2--small", // For Select2 v4.1
             dropdownCssClass: "select2--small",
         })

         $(document).on('change', '#unit', function() {
             let val = $(this).val();
             if (val) {
                 $('.unit').text(val)
             } else {
                 $('.unit').text('--')
             }

         })

         $(document).on('change', '#category', function() {
             let category_id = $(this).val();
             $('#products').html("<option value=''></option>")
             if (category_id) {
                 $.post(siteurl + 'product/load_product', {
                     category_id
                 }).done(function(result) {
                     obj = JSON.parse(result);
                     for (let i = 0; i < obj.length; i++) {
                         opt = new Option(obj[i].name, obj[i].id);
                         $(opt).html(obj[i].name);
                         $("#products").append(opt);
                     }
                 });
             } else {
                 $('#products').html("<option value=''></option>")
             }

         })
     })

     $('#unit').on('change', function() {
         var data = $(".select option:selected").text();
         alert(data)
     })


     $(document).on('click', '#add_products', function() {
         $('#modalService').modal('show');

     })

     $(document).on('click', '#save_service', function() {
         let name = $('input[name="service_name"]').val()
         $('input[name="service_name"]').removeClass('is-invalid')
         $('.msg_name').addClass('d-none')
         if (!name) {
             $('input[name="service_name"]').addClass('is-invalid')
             $('.msg_name').removeClass('d-none')
         } else {
             $.ajax({
                 url: siteurl + 'product/save_product',
                 type: 'POST',
                 dataType: 'JSON',
                 data: {
                     name
                 },
                 success: function(result) {
                     if (result.status == '1') {
                         Swal.fire("Berhasil!", result.msg, "success", 1500).then(function() {
                             location.reload()
                         })
                     } else {
                         Swal.fire('Gagal!', result.msg, "warning")
                     }
                 },
                 error: function(result) {
                     Swal.fire('Error!', 'Server timr out', "error")
                 }
             })
         }
     })

     $(document).on('click', '#save', function() {
         let formdata = new FormData($('#form-product')[0])
         $.ajax({
             url: siteurl + 'product/save',
             data: formdata,
             processData: false,
             contentType: false,
             async: false,
             type: 'POST',
             dataType: 'JSON',
             success: function(result) {
                 Swal.fire({
                     title: 'Berhasil!',
                     text: 'Data produk berhasil disimpan',
                     icon: 'success',
                     timer: 1500,
                 }).then(function() {
                     location.href = siteurl + 'list-products'
                 })
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

     //  INPUT WHOLESALER PRICE (GROSIR)
     $(document).on('change', '#wholesale_price', function() {
         let check = $(this).is(':checked')
         $('#input_wholesale_price').text('')
         if (check) {
             $('#input_wholesale_price').load(siteurl + 'product/wholesales')
         }
     })

     $(document).on('click', '#add_price', function() {
         let n = 0
         let html = '';
         n = $('#table_wh_price tbody tr').length + 1
         html = `
         <tr>
            <td class="text-center"><input type="text" class="form-control text-center form-control-sm" name="wh_price[` + n + `][qty_min]" placeholder="0"></td>
            <td><input type="text" class="form-control text-end form-control-sm currency numeric" name="wh_price[` + n + `][price]" placeholder="0"></td>
            <td class="text-center"><button type="button" class="btn btn-sm text-danger del_price" data-id=""><i class="fa fa-times"></i></button></td>
        </tr>`;
         $('#table_wh_price tbody').append(html)
     })

     $(document).on('click', '#add_cost_item', function() {
         let n = 0
         let html = '';
         n = $('#table_cost_item tbody tr').length + 1
         html = `
         <tr>
         <td>` + n + `</td>
         <td>
           <select name="cost_item[` + n + `][cost_id]" class="from-select select">
             <option value=""></option>
             <?php foreach ($cost_item as $ci) : ?>
                 <option value="<?= $ci->id; ?>"><?= $ci->cost_item; ?></option>
             <?php endforeach; ?>
         </select>
         </td>
            <td>
            <input type="text" class="form-control d-none form-control-sm" name="cost_item[` + n + `][name]" placeholder="0">
                <input type="text" class="form-control text-end form-control-sm currency numeric cost_price" name="cost_item[` + n + `][cost_value]" placeholder="0">
            </td>
            <td><button type="button" class="btn btn-sm text-danger del_cost" data-id=""><i class="fa fa-times"></i></button></td>
        </tr>`;
         $('#table_cost_item tbody').append(html)
         $('.select').select2({
             placeholder: '~ Pilih ~',
             allowClear: true,
             width: "100%",
             theme: "bootstrap-5",
             selectionCssClass: "select2--small", // For Select2 v4.1
             dropdownCssClass: "select2--small",
         });
     })

     $(document).on('click', '.del_price', function() {
         let id = $(this).data('id');
         if (id != '') {
             Swal.fire({
                 title: 'Konfirmasi',
                 html: 'Harga yang sudah di hapus tidak bisa dikebalikan lagi! <i class="fa fa-trash"></i>',
                 icon: 'question',
                 showCancelButton: true,
                 cancelButtonText: 'Batal',
                 confirmButtonText: 'Ya, Hapus'
             }).then((value) => {
                 if (value.isConfirmed == true) {
                     $.ajax({
                         url: siteurl + 'product/delete_price',
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

     $(document).on('click', '.del_cost', function() {
         let id = $(this).data('id');
         let row = $(this);
         if (id != '') {
             Swal.fire({
                 title: 'Konfirmasi',
                 html: 'Harga yang sudah di hapus tidak bisa dikebalikan lagi! <i class="fa fa-trash"></i>',
                 icon: 'question',
                 showCancelButton: true,
                 cancelButtonText: 'Batal',
                 confirmButtonText: 'Ya, Hapus'
             }).then((value) => {
                 if (value.isConfirmed == true) {
                     $.ajax({
                         url: siteurl + 'product/delete_cost',
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
                                     $(row).parents('tr').remove();
                                     total_cost()
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
         } else {
             $(this).parents('tr').remove();
         }
     })

     $(document).on('change', '.cost_price', function() {
         total_cost();
     })

     //  INPUT DATA FINISHING
     $(document).on('change', '#finishing', function() {
         let cek = $(this).is(':checked')
     })


     function total_cost() {
         let total_cost = 0;
         $(".cost_price").each(function() {
             total_cost += Number($(this).val().replace(/[\.,]/g, '') || 0)
         })

         $('#cost').val(new Intl.NumberFormat().format(total_cost.toFixed()))
     }

     //  $(document).on('click', '#add_finishing', function() {
     //      let n = 0
     //      let html = '';
     //      n = $('#table_finishing tbody tr').length + 1
     //      html = `
     //      <tr>
     //         <td><input type="text" class="form-control form-control-sm" name="finishing[` + n + `][finishing_name]" placeholder="Cth : Laminating"></td>
     //         <td><button type="button" class="btn btn-sm btn-default del_fin" data-id=""><i class="fa fa-times"></i></button></td>
     //         </tr>`;
     //      $('#table_finishing tbody').append(html)
     //  })

     //  $(document).on('click', '.del_fin', function() {
     //      let id = $(this).data('id');
     //      if (id != '') {
     //          Swal.fire({
     //              title: 'Konfirmasi',
     //              html: 'Finishing yang sudah di hapus tidak bisa dikebalikan lagi! <i class="fa fa-trash"></i>',
     //              icon: 'question',
     //              showCancelButton: true,
     //              cancelButtonText: 'Batal',
     //              confirmButtonText: 'Ya, Hapus'
     //          }).then((value) => {
     //              if (value.isConfirmed == true) {
     //                  $.ajax({
     //                      url: siteurl + 'product/delete_finishing',
     //                      type: 'POST',
     //                      dataType: 'JSON',
     //                      data: {
     //                          id
     //                      },
     //                      success: function(result) {
     //                          if (result.status == 1) {
     //                              Swal.fire({
     //                                  title: 'Berhasil!',
     //                                  text: result.msg,
     //                                  icon: 'success',
     //                                  timer: 1500
     //                              }).then(function() {
     //                                  location.reload();
     //                              })
     //                              $(this).parents('tr').remove();
     //                          } else {
     //                              Swal.fire({
     //                                  title: 'Gagal!',
     //                                  text: result.msg,
     //                                  icon: 'warning',
     //                                  timer: 3000
     //                              })
     //                          }
     //                      },
     //                      error: function(result) {
     //                          Swal.fire({
     //                              title: 'Error!',
     //                              text: 'Server timeout',
     //                              icon: 'error',
     //                              timer: 3000
     //                          })
     //                      }
     //                  })
     //              }
     //          })
     //      } else {
     //          $(this).parents('tr').remove();
     //      }
     //  })
 </script>