 <div class="d-flex justify-content-between mb-3">
     <h3 class="card-title">Data Produk</h3>
     <!-- <button class="btn btn-primary"><i class="fa fa-plus"></i> Transaksi Baru</button> -->
     <a href="<?= base_url('add-product'); ?>" class="btn btn-primary"><i data-feather="plus"></i> Tambah Produk</a>
 </div>

 <div class="card">
     <div class="card-body">
         <div class="table-responsive p-2">
             <table class="datatable table table-striped table-hover table-sm">
                 <thead class="table-primary">
                     <tr>
                         <th width="80px" class="px-2">No</th>
                         <th>Nama Jasa</th>
                         <th>Kode</th>
                         <th class="text-center">Status</th>
                         <th class="text-center">User</th>
                         <th class="text-center">Waktu</th>
                         <th width="130px">Opsi</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php $n = 0;
                        foreach ($data as $dt) : $n++ ?>
                         <tr>
                             <td><?= $n; ?></td>
                             <td><?= $dt->name; ?></td>
                             <td><?= $dt->id; ?></td>
                             <td class="text-center"><?= $sts[$dt->active]; ?></td>
                             <td class="text-center"><?= ($dt->created_by) ? $usr[$dt->created_by] : ''; ?></td>
                             <td class="text-center"><?= $dt->created_at; ?></td>
                             <td>
                                 <!-- <button type="button" class="mb-1 btn btn-default text-primary btn-sm view" data-id="<?= $dt->id; ?>" title="Lihat"><i data-feather="search"></i></button> -->
                                 <a href="<?= base_url('edit-product/' . $dt->id); ?>" class="mb-1 btn btn-icon text-primary btn-sm edit" title="Ubah"><i data-feather="edit-3"></i></a>
                                 <a href="<?= base_url('copy-product/') . $dt->id; ?>" class="mb-1 btn btn-icon text-success btn-sm" title="Copy Produk"><i data-feather="copy"></i></a>
                                 <button onclick="del('<?= $dt->id; ?>')" class="mb-1 btn btn-icon text-danger btn-sm" title="Batal"><i data-feather="trash"></i></button>
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
         $('.datatable').DataTable({
             stateSave: true
         });

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

     function del(id = '') {
         if (id) {
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
                         url: siteurl + 'product/delete_product',
                         type: 'POST',
                         dataType: 'JSON',
                         data: {
                             id
                         },
                         success: function(result) {
                             Swal.fire({
                                 title: 'Berhasil',
                                 text: result.msg,
                                 icon: 'success',
                                 timer: 3000
                             }).then(() => {
                                 location.reload()
                             })
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