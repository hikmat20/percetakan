<h2>Laporan Transaksi</h2>
<?php
$sDate      = $this->uri->segment(3);
$eDate      = $this->uri->segment(4);
$periode    = '';
if ($sDate && $eDate) {
    $periode = $sDate . '/' . $eDate;
}

echo '<pre>';
print_r($periode);
echo '</pre>';
// exit;
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <span for="" class="form-label col-lg-1 control-label">Tanggal :</span>
            <div class="col-lg-4">
                <div class="input-group">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    <input type="text" name="sdate" id="dates" class="form-control" required="required" title="">
                    <button class="btn btn-primary" id="getData">Tampil</button>
                    <button class="btn btn-warning" onclick="location.href=siteurl+controller+'report_sales/'"><i class="fa fa-refresh"></i> Reset</button>
                </div>
            </div>
            <div class="col-lg-7 text-end">
                <a href="<?= base_url('reports/printSummary/') . $periode; ?>" target="_blank" class="btn btn-warning text-end"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
        <hr>
        <!-- javascript behavior vertical pills -->
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-summary-tab" data-bs-toggle="pill" href="#v-pills-summary" role="tab" aria-controls="v-pills-summary" aria-selected="true">Ringkasan Penjualan</a>
                    <a class="nav-link" id="v-pills-payment-tab" data-bs-toggle="pill" href="#v-pills-payment" role="tab" aria-controls="v-pills-payment" aria-selected="false">Pembayaran</a>
                    <a class="nav-link" id="v-pills-product_salez-tab" data-bs-toggle="pill" href="#v-pills-product_sales" role="tab" aria-controls="v-pills-product_sales" aria-selected="false">Produk Terjual</a>
                    <a class="nav-link" id="v-pills-discount-tab" data-bs-toggle="pill" href="#v-pills-discount" role="tab" aria-controls="v-pills-discount" aria-selected="false">Diskon Produk</a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active printableTable" id="v-pills-summary" role="tabpanel" aria-labelledby="v-pills-summary-tab">
                        <!-- Ringkasan -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4><i class="fa fa-file"></i> Laporan Ringkasan Penjualan</h4>
                        </div>
                        <table class="table table-borderles table-condensed mb-2">
                            <thead class="table-primary">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Total Penjualan</span>
                            <span><?= number_format($sum_sales); ?></span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Diskon</span>
                            <span>(<?= number_format($discount); ?>)</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Kas Masuk</span>
                            <span><?= number_format($cash_in); ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Kas Keluar</span>
                            <span>(<?= number_format($cash_out); ?>)</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold"><?= number_format($total_sum); ?></span>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                        <!-- Ringkasan -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4><i class="fa fa-file"></i> Laporan Pembayaran</h4>
                        </div>
                        <table class="table table-borderles table-condensed mb-2">
                            <thead class="table-primary">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Pembayaran Cash</span>
                            <span><?= number_format($sum_pay_cash); ?></span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Pembayaran Transfer</span>
                            <span><?= number_format($sum_pay_trf); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold"><?= number_format($total_payment); ?></span>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-product_sales" role="tabpanel" aria-labelledby="v-pills-product_salez-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4><i class="fa fa-file"></i> Laporan Produk terjual</h4>
                        </div>
                        <table class="table table-borderles table-sm mb-2 datatable">
                            <thead class="table-primary">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_sales_product = 0;
                                foreach ($sales_product as $sls) :
                                    $total_sales_product += $sls->grand_total;
                                ?>
                                    <tr>
                                        <td><?= $sls->product_detail_name; ?></td>
                                        <td class="text-end"><?= ($sls->qty); ?></td>
                                        <td class="text-end"><?= number_format($sls->grand_total); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold"><?= number_format($total_sales_product); ?></span>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-discount" role="tabpanel" aria-labelledby="v-pills-discount-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4><i class="fa fa-file"></i> Laporan Diskon Produk </h4>
                        </div>
                        <table class="table table-borderles table-sm mb-2">
                            <thead class="table-primary">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_disc_product = 0;
                                foreach ($discount_product as $disc) :
                                    $total_disc_product += $disc->discount;
                                ?>
                                    <tr>
                                        <td><?= $disc->product_detail_name; ?></td>
                                        <td class="text-end"><?= ($disc->count_product); ?></td>
                                        <td class="text-end"><?= number_format($disc->discount); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold"><?= number_format($total_disc_product); ?></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
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
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
<script>
    $(document).ready(function() {
        $('input[name="sdate"]').daterangepicker();
        // $('table').DataTable();
        Datatbles();
    })

    $(document).on('click', '#getData', function() {
        let data_type = $(this).data('type')
        let dates = $('#dates').val();
        let split = dates.split(' - ');
        // console.log(split);
        var sDate = split[0]
        var eDate = split[1]
        sDate = sDate.replaceAll('/', '-');
        eDate = eDate.replaceAll('/', '-');
        location.href = siteurl + controller + 'report_sales/' + sDate + "/" + eDate
    })

    function Datatbles() {
        $('.datatable').DataTable();
    }

    function printSummary() {

        // var printData = load(siteurl + controller + 'printSummary'
        //     console.log(printData); +
        // window.frames["print_frame"].load(siteurl + controller + 'printSummary')
        // newWin = window.open("");
        // newWin.document.write(printData.outerHTML);
        // newWin.print();
        // newWin.close();
        // window.frames["print_frame"][0].src = siteurl + controller + 'printSummary';
        // $('iframe[name="print_frame"]').src = siteurl + controller + 'printSummary'
        // document.getElementsByName('print_frame')[0].src = siteurl + controller + 'printSummary';
        // window.frames["print_frame"].document.body.innerHTML = document.getElementById("v-pills-summary").innerHTML;
        fetch(siteurl + controller + 'printSummary')
            .then(function(response) {
                return response.text();
            })
            .then(function(body) {
                document.querySelector('iframe[name="print_frame"]').innerHTML = body;
            });

        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }

    // function printDiv() {
    //     window.frames["print_frame"].document.body.innerHTML = document.getElementById("v-pills-summary").innerHTML;
    //     window.frames["print_frame"].window.focus();
    //     window.frames["print_frame"].window.print();
    // }
</script>