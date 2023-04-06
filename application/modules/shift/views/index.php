 <div class="d-flex justify-content-between mb-3">
     <h2 class="card-title"><?= $title; ?></h2>
 </div>

 <form id="form-category">
     <div class="card mb-2">
         <div class="card-body">
             <fieldset class="form-group row mb-5">
                 <h4 class="col-sm-12 fw-bold">Pengaturan Shift</h4>
             </fieldset>
             <div class="row">
                 <div class="col-3">
                     <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                         <a class="nav-link active" id="active-shift-tab" data-bs-toggle="pill" href="#active-shift" role="tab" aria-controls="active-shift" aria-selected="true">Shift Saat ini</a>
                         <a class="nav-link" id="history-shift-tab" data-bs-toggle="pill" href="#history-shift" role="tab" aria-controls="history-shift" aria-selected="false">Riwayat Shift</a>
                     </div>
                 </div>

                 <div class="col-9" style="border-left: 1px solid #cecece;">
                     <div class="tab-content" id="v-pills-tabContent">
                         <div class="tab-pane fade show active" id="active-shift" role="tabpanel" aria-labelledby="active-shift-tab">
                             <?php if ($shift) : ?>
                                 <!-- active shift -->
                                 <div class="row mb-3">
                                     <div class="col-md-12">
                                         <div class="alert alert-secondary text-center" role="alert">
                                             <strong>SHIFT SAAT INI</strong>
                                         </div>

                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Nama Kasir</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end fw-bold">
                                             <span><?= ($shift->username) ?: '~'; ?></span>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Mulai Shift</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <span><?= ($shift->start_shift) ?: '~'; ?></span>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Uang Masuk</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span><?= ($shift->qty_income) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Uang Keluar</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span><?= ($shift->qty_expense) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Transaksi</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span><?= ($shift->qty_transactions) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Produk Terjual</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span><?= ($shift->qty_sales_product) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3 mt-5">
                                     <div class="col-md-6">
                                         <label class="form-label fw-bold h4">Saldo</label>
                                     </div>
                                     <div class="col-md-6">
                                     </div>
                                 </div>
                                 <hr>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Saldo Awal</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span>Rp. <?= (number_format($shift->beginning_balance)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Total Penjualan</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span>Rp. <?= (number_format($shift->cash_sales)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label fw-bold">Perkiraan Saldo Akhir</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span>Rp. <?= (number_format($shift->expected_ending_balance)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <hr>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Pembayaran Tunai</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span>Rp. <?= (number_format($shift->cash_payment)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Total Uang Masuk</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span>Rp. <?= (number_format($shift->income)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label">Total Uang Keluar</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span>Rp. <?= (number_format($shift->expenses)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <hr>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label fw-bold">Saldo Akhir</label>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid text-end">
                                             <a href="javascript:void(0)" class="btn-link text-secondary">
                                                 <span>Rp. <?= (number_format($shift->ending_balance)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                                 <hr>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <div class="d-grid">
                                             <button type="button" id="modal_summary" data-bs-toggle="modal" data-bs-target="#modelId" class="btn btn-outline-primary">Akhiri Shift</button>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="d-grid">
                                             <a href="<?= base_url('shift/report_shift/') . $shift->id; ?>" id="print_report_shift" class="btn btn-outline-secondary">Cetak Laporan Shift</a>
                                         </div>
                                     </div>
                                 </div>
                             <?php else : ?>
                                 <div class="row">
                                     <div class="col-md-4">
                                         <div class="mb-3">
                                             <label for="beginning_balance" class="form-label d-block">Saldo Awal</label>
                                             <small id="helpId" class="text-muted">Isikan nilai uang pada laci kasir saat memulai shift</small>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <input type="text" name="beginning_balance" id="beginning_balance" class="form-control text-end numeric currency" placeholder="0">
                                         <small class="invalid-feedback text-danger">Mohon input saldo awal terlebih dahulu</small>
                                         <div class="mt-3 d-grid mb-4">
                                             <button type="button" class="btn btn-primary" id="start_shift">Mulai Shift</button>
                                         </div>
                                     </div>
                                 </div>
                             <?php endif; ?>
                         </div>
                         <div class="tab-pane fade" id="history-shift" role="tabpanel" aria-labelledby="history-shift-tab">
                             <div class="row mb-3">
                                 <div class="col-md-12">
                                     <div class="alert alert-secondary text-center" role="alert">
                                         <strong>RIWAYAT SHIFT</strong>
                                     </div>

                                 </div>
                             </div>

                             <?php if (isset($shift)) : ?>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label fw-bold h4">Shift Aktif saat ini</label>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label"><span class="fw-bold"><?= (isset($shift) && $shift->username) ? $shift->username . " - " . $shift->start_shift : ''; ?></label>
                                     </div>
                                     <div class="col-md-6 text-end">
                                         <a href="javascript:void(0)" class="btn-link text-secondary">
                                             <span>Rp. <?= (isset($shift) ? number_format($shift->ending_balance) : '-') ?: '0'; ?><i data-feather="chevron-right"></i></span>
                                         </a>
                                     </div>
                                 </div>
                             <?php endif; ?>

                             <div class="row mb-3">
                                 <div class="col-md-6">
                                     <label class="form-label fw-bold h4">Shift Ditutup</label>
                                 </div>
                             </div>
                             <?php foreach ($history as $his) : ?>
                                 <div class="row mb-3">
                                     <div class="col-md-6">
                                         <label class="form-label"><?= ($his->start_shift); ?></label>
                                     </div>
                                     <div class="col-md-6 text-end">
                                         <a href="javascript:void(0)" class="btn-link text-secondary">
                                             <span><?= (number_format($his->ending_balance)) ?: '0'; ?><i data-feather="chevron-right"></i></span>
                                         </a>
                                     </div>
                                 </div>
                             <?php endforeach; ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </form>

 <form id="form-end-shift">
     <!-- Modal -->
     <div class="modal fade" id="modelId" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="modelTitleId" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title">Akhiri Shift</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div class="container-fluid" id="data_modal">
                         Not data available
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                 </div>
             </div>
         </div>
     </div>
 </form>

 <script>
     $(document).ready(function() {
         $(document).on('click', '#start_shift', function() {
             let beginning = $('#beginning_balance').val();
             $('#beginning_balance').removeClass('is-invalid');
             if (!beginning) {
                 $('#beginning_balance').addClass('is-invalid');
                 return false
             }

             $.ajax({
                 url: siteurl + controller + 'save_beginning_balance',
                 dataType: 'JSON',
                 type: 'POST',
                 data: {
                     beginning
                 },
                 success: function(result) {
                     if (result.status == '1') {
                         Swal.fire({
                             title: 'Berhasil!',
                             text: result.pesan,
                             icon: 'success',
                             timer: 1500,
                         }).then(function() {
                             location.reload();
                         })
                     } else {
                         Swal.fire({
                             title: 'Warning!',
                             text: result.pesan,
                             icon: 'warning',
                             timer: 1500,
                         })
                     }
                 },
                 error: function(result) {
                     Swal.fire({
                         title: 'Error',
                         text: 'Server time out. Error!',
                         icon: 'error',
                         timer: 3000,
                     })
                 }
             })
         })

         $(document).on('click', '#modal_summary', function() {
             $('#data_modal').load(siteurl + controller + 'summary_shift')
         })

         $(document).on('input change', '#actual_ending', function() {
             let ending = $('#ending_balance_text').text().replace(/[,.]/g, '')
             let actual = $('#actual_ending').val().replace(/[,.]/g, '')
             let difference = 0;
             difference = parseInt(actual) - parseInt(ending)
             console.log(ending + ", " + actual + ", " + difference);
             $('#difference').val(new Intl.NumberFormat().format(difference))
         })

         $(document).on('click', '#ending_shift', function() {
             $('#actual_ending').removeClass('is-invalid')
             let ending = $('#ending_balance_text').text().replace(/[,.]/g, '')
             let actual = $('#actual_ending').val().replace(/[,.]/g, '')
             let difference = $('#difference').val().replace(/[,.]/g, '')
             let note = $('#note').val()
             if (!actual) {
                 $('#actual_ending').addClass('is-invalid')
             } else {
                 Swal.fire({
                     title: 'Konfirmasi',
                     text: 'Anda yakini ingin mengkhiri shift?',
                     icon: 'question',
                     showCancelButton: true
                 }).then((value) => {
                     if (value.isConfirmed) {
                         console.log('end');
                         $.ajax({
                             url: siteurl + controller + 'ending_shift',
                             type: 'POST',
                             dataType: 'JSON',
                             data: {
                                 ending,
                                 actual,
                                 difference,
                                 note,
                             },
                             success: function(result) {
                                 if (result.status == 1) {
                                     Swal.fire(
                                         'Berhasil!',
                                         result.pesan,
                                         'success'
                                     )
                                     $('#data_modal').load(siteurl + controller + 'report_ending_shift')
                                 } else {
                                     Swal.fire(
                                         'Warning!',
                                         result.pesan,
                                         'warning'
                                     )
                                 }
                             },
                             error: function(result) {
                                 Swal.fire(
                                     'Error!',
                                     'Server time out. Error!',
                                     'error'
                                 )
                             }
                         })
                     }
                 })
             }

         })

         //  $(document).on('click', '#print_report_shift', function() {
         //      $('#actual_ending').removeClass('is-invalid')
         //      let ending = $('#ending_balance_text').text().replace(/[,.]/g, '')
         //      let actual = $('#actual_ending').val().replace(/[,.]/g, '')
         //      let difference = $('#difference').val().replace(/[,.]/g, '')
         //      let note = $('#note').val()
         //      if (!actual) {
         //          $('#actual_ending').addClass('is-invalid')
         //      } else {
         //          Swal.fire({
         //              title: 'Konfirmasi',
         //              text: 'Anda yakini ingin mengkhiri shift?',
         //              icon: 'question',
         //              showCancelButton: true
         //          }).then((value) => {
         //              if (value.isConfirmed) {
         //                  console.log('end');
         //                  $.ajax({
         //                      url: siteurl + controller + 'ending_shift',
         //                      type: 'POST',
         //                      dataType: 'JSON',
         //                      data: {
         //                          ending,
         //                          actual,
         //                          difference,
         //                          note,
         //                      },
         //                      success: function(result) {
         //                          if (result.status == 1) {
         //                              Swal.fire(
         //                                  'Berhasil!',
         //                                  result.pesan,
         //                                  'success'
         //                              )
         //                              $('#data_modal').load(siteurl + controller + 'report_ending_shift')
         //                          } else {
         //                              Swal.fire(
         //                                  'Warning!',
         //                                  result.pesan,
         //                                  'warning'
         //                              )
         //                          }
         //                      },
         //                      error: function(result) {
         //                          Swal.fire(
         //                              'Error!',
         //                              'Server time out. Error!',
         //                              'error'
         //                          )
         //                      }
         //                  })
         //              }
         //          })
         //      }

         //  })
     })
 </script>