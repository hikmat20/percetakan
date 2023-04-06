<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan</title>
</head>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
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

    .text-start {
        text-align: left;
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
        <h1 style="font-size: 24px;">LAPORAN TRANSAKSI per KARYAWAN</h1>
        <span>Periode Tanggal : <?= $periode; ?></span> | <span>OP : <?= (ucfirst($full_name)) ?: 'Semua'; ?></span>
    </div>
    <hr>
    <table class="table table-sm table-data table-bordered">
        <thead>
            <tr class="bg-gray">
                <th>No</th>
                <th class="text-start">No Trans</th>
                <th class="text-start">Pelangan</th>
                <th class="text-end">Subtotal</th>
                <th class="text-end">Discount</th>
                <th class="text-end">Total</th>
                <th class="text-center">OP</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = $total = 0;
            foreach ($transactions as $trs) : $n++;
                $total += $trs->grand_total; ?>
                <tr>
                    <td><?= $n; ?></td>
                    <td><?= $trs->id; ?></td>
                    <td><?= $trs->customer_name; ?></td>
                    <td class="text-end"><?= number_format($trs->subtotal); ?></td>
                    <td class="text-end"><?= number_format($trs->discount); ?></td>
                    <td class="text-end"><?= number_format($trs->grand_total); ?></td>
                    <td class="text-center"><?= ucfirst($trs->created_by_name); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="bg-gray">
                <th colspan="5" class="text-end">Total</th>
                <th class="text-end"><?= number_format($total); ?></th>
                <t class="text-end"></t>
            </tr>
        </tfoot>
    </table>

</body>

</html>