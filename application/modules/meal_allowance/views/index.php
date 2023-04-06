 <div class="d-flex justify-content-between mb-3">
     <h3 class="card-title"><?= $title; ?></h3>
     <!-- <button class="btn btn-primary"><i class="fa fa-plus"></i> Transaksi Baru</button> -->
     <a href="<?= base_url('meal_allowance/add'); ?>" class="btn btn-primary"><i data-feather="plus"></i> Tambah Uang Makan</a>
 </div>
 <div class="card">
     <div class="card-header bg-white">
         <div class="row">
             <div class="col-md-3">
                 <div class="input-group">
                     <input type="date" class="form-control" id="date_filter" value="<?= date('Y-m-d'); ?>">
                     <button type="button" class="btn btn-primary" id="show">Tampil</button>
                     <a href="<?= base_url('meal_allowance'); ?>" class="btn btn-warning"><i class="fa fa-refresh"></i> Reset</a>
                 </div>
             </div>
         </div>
     </div>
     <div class="card-body">
         <div class="table-responsive p-2" id="meal-data">
             <table class="table table- datatable table-sm" id="meal_allowance">
                 <thead class="table-light">
                     <tr>
                         <th width="50">No</th>
                         <th>Nama Karyawan</th>
                         <th>Tanggal</th>
                         <th class="text-end">Jumlah Uang Makan</th>
                         <th width="150" class="text-center">Opsi</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $n = 0;
                        foreach ($data as $cr) :
                            $n++; ?>
                         <tr>
                             <td><?= $n; ?></td>
                             <td><?= $cr->employee_name; ?></td>
                             <td><?= ($cr->date); ?></td>
                             <td class="text-end text-primary"><?= number_format($cr->total_value); ?></td>
                             <td class="text-center">
                                 <a href="<?= base_url('meal_allowance/edit/') . $cr->id; ?>" class="btn btn-light text-warning btn-icon btn-sm"><i class="fa fa-edit"></i></a>
                                 <button type="button" title="Hapus" class="btn btn-light text-danger btn-icon btn-sm delete" onclick="del(<?= $cr->id; ?>)"><i class="fa fa-trash"></i></button>
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
         if (id) {
             Swal.fire({
                 title: 'Konfirmasi',
                 html: 'Data Uang Makan akan di hapus? <span class="text-danger fa fa-trash"></span> ?',
                 icon: 'question',
                 showCancelButton: true,
             }).then((value) => {
                 if (value.isConfirmed == true) {
                     $.ajax({
                         url: siteurl + controller + 'delete',
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