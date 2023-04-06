 <div class="d-flex justify-content-between mb-3">
     <h3 class="card-title"><?= $title; ?></h3>
     <a href="<?= base_url('employees/add'); ?>" class="btn btn-primary"><i data-feather="plus"></i> Tambah Karyawan Baru</a>
 </div>
 <div class="card">
     <div class="card-body">
         <div class="table-responsive p-2" id="employees-data">
             <table class="table datatable table-sm" id="table-employess">
                 <thead class="table-light">
                     <tr>
                         <th width="50">No</th>
                         <th width="100">Id</th>
                         <th>Nama Karyawan</th>
                         <th class="text-center">Tanggal Masuk</th>
                         <th class="">Telepon</th>
                         <th class="">Alamat</th>
                         <th class="text-center">Bagian</th>
                         <th class="text-center">Status</th>
                         <th width="150" class="text-center">Opsi</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $n = 0;
                        foreach ($data as $dt) :
                            $n++; ?>
                         <tr>
                             <td><?= $n; ?></td>
                             <td><?= $dt->id; ?></td>
                             <td><?= $dt->employee_name; ?></td>
                             <td class="text-center"><?= ($dt->hire_date); ?></td>
                             <td class="text-"><?= ($dt->phone); ?></td>
                             <td><?= ($dt->address); ?></td>
                             <td class="text-center"><?= ($dt->position_name); ?></td>
                             <td class="text-center"><?= ($sts[$dt->status]); ?></td>
                             <td class="text-center">
                                 <?php if ($dt->status == 'ACTIVE') : ?>
                                     <a href="<?= base_url('employees/edit/') . $dt->id; ?>" title="Ubah" class="btn btn-light text-info btn-icon btn-sm"><i class="fa fa-edit"></i></a>
                                     <button type="button" title="Resign" class="btn btn-light text-danger btn-icon btn-sm" onclick="del('<?= $dt->id; ?>')"><i class="fa fa-sign-out"></i></button>
                                 <?php endif; ?>
                             </td>
                         </tr>
                     <?php endforeach; ?>
                 </tbody>
             </table>
         </div>
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
                             $('#modal').modal('show');
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

         $(document).on('click', '.edit', function() {
             let id = $(this).data('id');

             if (id) {
                 $.ajax({
                     url: siteurl + controller + 'edit',
                     type: 'POST',
                     data: {
                         id
                     },
                     success: function(result) {
                         if (result) {
                             $('#viewData').html(result)
                             $('#modal').modal('show');
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

         $(document).on('click', '#show', function() {
             let date = $('#date_filter').val();

             if (date) {
                 $.ajax({
                     url: siteurl + controller + 'show',
                     type: 'POST',
                     data: {
                         date
                     },
                     success: function(result) {
                         console.log(result);
                         if (result) {
                             $('#meal-data').html(result);
                         } else {
                             $('table#meal_allowance tbody').html('<tr><td colspan="5" class="text-center text-muted"><i>Tidak ada data</i></td></tr>');
                         }
                         $('.datatable').DataTable();
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

     function del(id = '') {
         console.log(id);
         if (id) {
             Swal.fire({
                 title: 'Konfirmasi',
                 html: 'Karyawan akan Resign <span class="text-danger fa fa-sign-out"></span> ?',
                 icon: 'question',
                 showCancelButton: true,
             }).then((value) => {
                 if (value.isConfirmed == true) {
                     $.ajax({
                         url: siteurl + controller + 'resign',
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