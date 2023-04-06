 <div class="d-flex justify-content-between mb-3">
     <h3 class="card-title">Data Kategori</h3>
     <!-- <button class="btn btn-primary"><i class="fa fa-plus"></i> Transaksi Baru</button> -->
     <a href="<?= base_url('add-product-type'); ?>" class="btn btn-primary"><i data-feather="plus"></i> Tambah Jenis Produk</a>
 </div>

 <div class="card">
     <div class="card-body">
         <div class="table-responsive p-2">
             <table class="datatable table table-striped table-hover table-sm">
                 <thead class="table-primary">
                     <tr>
                         <th width="80px" class="px-2">No</th>
                         <th>Kode</th>
                         <th>Nama Jenis Produk</th>
                         <th>Kategori</th>
                         <th width="130px">Status</th>
                         <th width="130px">Opsi</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php $n = 0;
                        foreach ($product_type as $ptype) : $n++ ?>
                         <tr>
                             <td><?= $n; ?></td>
                             <td><?= $ptype->id; ?></td>
                             <td><?= $ptype->name; ?></td>
                             <td><?= $ptype->category_id; ?></td>
                             <td><?= $sts[$ptype->active]; ?></td>
                             <td>
                                 <!-- <button type="button" class="mb-1 btn btn-default text-primary btn-sm view" data-id="<?= $ptype->id; ?>" title="Lihat"><i data-feather="search"></i></button> -->
                                 <a href="<?= base_url('edit-product-type/' . $ptype->id); ?>" class="mb-1 btn btn-default text-primary btn-sm edit" title="Ubah"><i data-feather="edit-3"></i></a>
                                 <button onclick="del('<?= $ptype->id; ?>')" class="mb-1 btn btn-icon text-primary btn-sm cancel" title="Batal"><i data-feather="trash"></i></button>
                             </td>
                         </tr>
                     <?php endforeach; ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>

 <!-- Modal -->
 <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-md">
         <form id="form-services">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="staticBackdropLabel">Input Jasa Baru</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body" id="viewData"></div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                 </div>
             </div>
         </form>
     </div>
 </div>

 <script>
     $(document).ready(function() {
         $('.datatable').DataTable();
         $(document).on('click', '.view', function() {
             let id = $(this).data('id');

             if (id) {
                 $.ajax({
                     url: siteurl + controller + 'view',
                     type: 'POST',
                     data: {
                         id
                     },
                     success: function(result) {
                         if (result) {
                             $('#viewData').html(result)
                             $('#modal-trn').modal('show');
                         }
                     },
                     error: function(result) {
                         Swal.fire({
                             title: "Error!",
                             icon: 'error',
                             text: result.msg,
                             timer: 3000
                         })
                     }
                 })
             }
         })
     })

     $(document).on('click', '.btn-nav', function() {
         $('.btn-nav').removeClass('active');
         $(this).addClass('active');
     })

     function del(code = '') {
         if (code) {
             Swal.fire({
                 title: 'Hapus Produk?',
                 text: 'Produk yang sudah dihapus tidak bisa dikembalikan lagi.',
                 icon: 'question',
                 cancelButtonClass: 'btn-danger',
                 cancelButtonText: 'Batal',
                 showCancelButton: true,
                 confirmButtonText: 'OK, Hapus <span class="fa fa-trash"></span>',
             }).then((value) => {
                 if (value.isConfirmed == true) {
                     $.ajax({
                         url: siteurl + 'product/delete_product_type/' + code,
                         type: 'GET',
                         dataType: 'JSON',
                         success: function(result) {
                             if (result.status == 1) {
                                 Swal.fire({
                                     title: 'Berhasil',
                                     text: result.msg,
                                     icon: 'success',
                                     timer: 3000
                                 }).then(() => {
                                     location.reload()
                                 })

                             } else if (result.status == 2) {
                                 Swal.fire({
                                     title: 'Perhatian!',
                                     text: result.msg,
                                     icon: 'warning',
                                     timer: 3000
                                 })
                             }
                         },
                         error: function(result) {
                             Swal.fire({
                                 title: 'Peringatan!',
                                 text: result.msg,
                                 icon: 'warning',
                                 timer: 3000
                             })
                         }
                     })
                 }
             })
         } else {
             Swal.fire({
                 title: 'Error!',
                 text: 'Data tidak valid.',
                 icon: 'error',
                 timer: 3000
             })
         }
     }
 </script>