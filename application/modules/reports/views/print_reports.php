<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan</title>
</head>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;

    }

    table.table-data th,
    table.table-data td {
        /* border: 1px solid #eaeaea; */
        padding: 5px;
    }

    .bg-gray {
        background-color: #eaeaea;
    }

    .text-end {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }
</style>
<!-- <link rel="stylesheet" href="<?= base_url(); ?>assets\libs\bootstrap\dist\css\bootstrap.min.css"> -->

<body>
    <div class="text-center">
        <h1 style="font-size: 24px;">LAPORAN RINGKASAN PENJUALAN</h1>
        <span>Periode Tanggal : <?= $periode; ?></span>
    </div>
    <hr>
    <table class="table table-sm table-data table-bordered">
        <thead>
            <tr class="bg-gray">
                <th>Item</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Penjualan</td>
                <td class="text-end"><?= number_format($sum_sales); ?></td>
            </tr>
            <tr>
                <td>Diskon</td>
                <td class="text-end">(<?= number_format($discount); ?>)</td>
            </tr>
            <tr>
                <td>Kas Masuk</td>
                <td class="text-end"><?= number_format($cash_in); ?></td>
            </tr>
            <tr>
                <td>Kas Keluar</td>
                <td class="text-end">(<?= number_format($cash_out); ?>)</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bg-gray">
                <th>Total</th>
                <th class="text-end"><?= number_format($total_sum); ?></th>
            </tr>
        </tfoot>
    </table>

    <pagebreak></pagebreak>


    <div class="text-center">
        <h1 style="font-size: 24px;">LAPORAN PEMBAYARAN</h1>
        <span>Periode Tanggal : <?= $periode; ?></span>
    </div>
    <hr>
    <table class="table table-sm table-data table-bordered">
        <thead>
            <tr class="bg-gray">
                <th>Item</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pembayaran Cash</td>
                <td class="text-end"><?= number_format($cash_in); ?></td>
            </tr>
            <tr>
                <td>Pembayaran Transfer</td>
                <td class="text-end">(<?= number_format($cash_out); ?>)</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bg-gray">
                <th>Total</th>
                <th class="text-end"><?= number_format($total_payment); ?></th>
            </tr>
        </tfoot>
    </table>

    <pagebreak></pagebreak>

    <div class="text-center">
        <h1 style="font-size: 24px;">LAPORAN PRODUK TERJUAL</h1>
        <span>Periode Tanggal : <?= $periode; ?></span>
    </div>
    <table class="table-data">
        <thead>
            <tr class="bg-gray">
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
        <tfoot>
            <tr class="bg-gray">
                <th>Total</th>
                <th></th>
                <th class="text-end"><?= number_format($total_sales_product); ?></th>
            </tr>
        </tfoot>
    </table>

    <pagebreak></pagebreak>

    <div class="text-center">
        <h1 style="font-size: 24px;">LAPORAN DISKON PRODUK</h1>
        <span>Periode Tanggal : <?= $periode; ?></span>
    </div>
    <table class="table table-data">
        <thead class="table-primary">
            <tr class="bg-gray">
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
        <tfoot>
            <tr class="bg-gray">
                <th>Total</th>
                <th></th>
                <th class="text-end"><?= number_format($total_disc_product); ?></th>
            </tr>
        </tfoot>
    </table>

</body>

</html>