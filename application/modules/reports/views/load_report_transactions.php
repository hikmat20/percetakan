 <div class="row">
     <div class="col-md-4">
         <div class="card border-right border-1 shadow-none">
             <div class="card-body text-center">
                 <h2><?= $countTrans; ?></h2>
                 <span>Transaksi</span>
             </div>
         </div>
     </div>
     <div class="col-md-4">
         <div class="card border-right border-1 shadow-none">
             <div class="card-body text-center">
                 <h2>Rp. <?= number_format($sumTrans); ?></h2>
                 <span>Total Transaksi</span>
             </div>
         </div>
     </div>
     <div class="col-md-4">
         <div class="card border-right border-1 shadow-none">
             <div class="card-body text-center">
                 <h2><?= $countProduct; ?></h2>
                 <span>Produk Terjual</span>
             </div>
         </div>
     </div>
 </div>
 <div class="pt-1">
     <table class="table table-sm datatable" id="list_trans">
         <thead class="table-primary">
             <tr>
                 <th width="80px">No</th>
                 <th>No. Transaksi</th>
                 <th class="text-center">Tanggal</th>
                 <th>Pelanggan</th>
                 <th class="text-end">Total</th>
                 <th class="text-center">Kasir</th>
                 <th class="text-center">Lihat</th>
             </tr>
         </thead>
         <tbody>
             <?php
                if ($trans) : $n = $total = 0;
                    foreach ($trans as $tr) : $n++; ?>
                     <tr>
                         <td class="text"><?= $n; ?></td>
                         <td class="text"><?= $tr->id; ?></td>
                         <td class="text-center"><?= $tr->date; ?></td>
                         <td class="text"><?= $tr->customer_name; ?></td>
                         <td class="text-end"><?= $tr->grand_total; ?></td>
                         <td class="text-end"><?= $tr->created_by_name; ?></td>
                         <td class="text-center"><button data-id="<?= $tr->id; ?>" type="button" data-bs-toggle="modal" data-bs-target="#modelId" class="btn btn-xs btn-icon dtl_trans btn-warning"><i class="fa fa-eye"></i></button></td>
                     </tr>
             <?php endforeach;
                endif; ?>
         </tbody>
     </table>
 </div>

 <script>
     $('.datatable').DataTable()
 </script>