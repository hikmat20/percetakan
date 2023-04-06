<h2>Laporan Transaksi</h2>
<div class="card">
    <div class="card-body">
        <div class="row">
            <span for="" class="form-label col-lg-1 control-label">Tanggal :</span>
            <div class="col-lg-4">
                <div class="input-group">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    <input type="text" name="sdate" id="dates" class="form-control" value="" required="required" title="">
                    <button class="btn btn-primary" id="getData">Tampil</button>
                    <button class="btn btn-warning" onclick="location.href=siteurl+controller+'report_transactions'"><i class="fa fa-refresh"></i> Reset</button>
                </div>
            </div>
            <div class="col-lg-4 offset-3 text-end">
                <!-- <div class="input-group">
                    <div class="input-group-text"><i class="fa fa-file-text-o"></i></div>
                    <input type="text" name="sid_trans" id="sid_trans" class="form-control" title="" placeholder="No. Trans">
                    <button class="btn btn-secondary"><i class="fa fa-search"></i></button>
                </div> -->
                <button class="btn btn-light" type="button"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
        <hr>
        <div class="" id="list_trans">
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
                <table class="table table-sm datatable">
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
                                    <td class="text-center"><button data-id="<?= $tr->id; ?>" type="button" data-bs-toggle="modal" data-bs-target="#modelId" class="btn btn-xs btn-icon dtl_trans btn-light-secondary"><i class="fa fa-eye"></i></button></td>
                                </tr>
                        <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade modal-custome" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid text-center">
                    Data tidak tersedia
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('input[name="sdate"]').daterangepicker();
        // $('table').DataTable();
        Datatbles();
    })

    $(document).on('click', '#getData', function() {
        let dates = $('#dates').val();
        let split = dates.split(' - ');
        console.log(split);
        var sDate = split[0]
        var eDate = split[1]
        sDate = sDate.replaceAll('/', '-');
        eDate = eDate.replaceAll('/', '-');
        $('#list_trans').load(siteurl + controller + 'report_transactions/' + sDate + "/" + eDate)
        Datatbles();
    })

    $(document).on('click', '.dtl_trans', function() {
        let id = $(this).data('id');
        console.log(id);
        $('.modal-body').load(siteurl + controller + 'dtl_trans/' + id)
    })

    function Datatbles() {
        $('.datatable').DataTable();
    }
</script>