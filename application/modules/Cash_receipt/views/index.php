 <div class="d-flex justify-content-between mb-3">
     <h3 class="card-title">Data Kasbon</h3>
     <!-- <button class="btn btn-primary"><i class="fa fa-plus"></i> Transaksi Baru</button> -->
     <a href="<?= base_url('cash_receipt/add'); ?>" class="btn btn-primary"><i data-feather="plus"></i> Tambah Kasbon</a>
 </div>
 <div class="card">
     <div class="card-body">
         <div class="table-responsive p-2">
             <table class="table table- datatable table-sm">
                 <thead class="table-light">
                     <tr>
                         <th width="50">No</th>
                         <th>Nama</th>
                         <th class="text-end">Total Kasbon</th>
                         <th class="text-end">Total Bayar</th>
                         <th class="text-end">Sisa Kasbon</th>
                         <th width="80" class="text-center">Opsi</th>
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
                             <td class="text-end text-primary"><?= number_format($cr->cash_value); ?></td>
                             <td class="text-end text-success"><?= number_format($cr->total_payment); ?></td>
                             <td class="text-end text-danger"><?= number_format($cr->sisa_kasbon); ?></td>
                             <td class="text-center">
                                 <!-- <button type="button" title="Bayar Kasbon" class="btn btn-light text-primary btn-icon btn-sm paydebt" data-id="<?= $cr->id; ?>"><i class="fa fa-money"></i></button> -->
                                 <a href="<?= base_url('cash_receipt/detail/') . $cr->id; ?>" title="Lihat Detail Kasbon" class="btn btn-warning text- btn-icon btn-xs" data-id="<?= $cr->id; ?>"><i class="fa fa-arrow-right"></i></a>
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
     <div class="modal-dialog modal-lg">
         <form id="form-payment">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="staticBackdropLabel">Rincian Kasbon</h5>
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

         $(document).on('click', '.paydebt', function() {
             let id = $(this).data('id');

             if (id) {
                 $.ajax({
                     url: siteurl + controller + 'payment_debt',
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
     })

     $(document).on('click', '#savePaymentReceipt', function() {
         valid = true;
         let employee = $('#employee_id').val();
         let date = $('#date').val();
         let value = $('#payment_value').val();
         $('#employee_id').removeClass('is-invalid')
         $('#date').removeClass('is-invalid')
         $('#payment_value').removeClass('is-invalid')

         if (!employee) {
             $('#employee_id').addClass('is-invalid')
             valid = false;
             console.log('employee_id');
         }
         if (!date) {
             $('#date').addClass('is-invalid')
             valid = false;
             console.log('date');
         }
         if (!value) {
             $('#payment_value').addClass('is-invalid')
             valid = false;
             console.log('payment_value');
         }

         if (valid == true) {
             let formdata = new FormData($('#form-payment')[0])
             $.ajax({
                 url: siteurl + controller + 'save_payment',
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

     $(document).on('click', '#add_services', function() {
         $('#viewData').load(siteurl + controller + 'add_services')
         $('#modal').modal('show')
     })

     $(document).on('click', '.edit', function() {
         $('#viewData').load(siteurl + controller + 'edit_services')
         $('#modal').modal('show')
     })

     $(document).on('click', '.btn-nav', function() {
         $('.btn-nav').removeClass('active');
         $(this).addClass('active');
     })

     function del(id = '') {
         if (id) {
             Swal.fire({
                 title: 'Konfirmasi',
                 html: 'Data Jasa ini akan dihapus <span class="text-danger fa fa-trash"></span> ?',
                 icon: 'question',
                 showCancelButton: true,
             }).then((value) => {
                 if (value.isConfirmed == true) {
                     $.ajax({
                         url: siteurl + controller + 'cancel',
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