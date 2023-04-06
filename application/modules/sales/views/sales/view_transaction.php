<div class="table-responsive pt-2 px-2">
    <table class="datatable table table-striped table-sm nowrap">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>No. Trans</th>
                <th>Pelannggan</th>
                <th class="text-end">Total</th>
                <th class="text-end">Total Bayar</th>
                <th class="text-end">Sisa</th>
                <th>Status</th>
                <th class="text-center">Tgl.</th>
                <th width="" class="text-center">Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 0;
            // echo "<pre>";
            // print_r($data);
            // echo "<pre>";
            // exit;
            foreach ($data as $dt) : $n++ ?>
                <tr>
                    <td><?= $n; ?></td>
                    <td><?= $dt->id; ?></td>
                    <td><?= $dt->customer_name; ?></td>
                    <td class="text-end"><?= number_format($dt->grand_total); ?></td>
                    <td class="text-end"><?= number_format($dt->total_payment); ?></td>
                    <td class="text-end"><?= number_format($dt->balance); ?></td>
                    <td class="text-center"><?= $sts[$dt->status]; ?></td>
                    <td class="text-center"><?= $dt->date; ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-light-info btn-icon btn-xs view" data-id="<?= $dt->id; ?>" title="Lihat"><i class="fa fa-search"></i></button>
                        <?php if ($dt->status == 'OPN' || $dt->status == 'PND') : ?>
                            <button type="button" class="btn btn-icon btn-light-primary btn-xs payment" data-id="<?= $dt->id; ?>" title="Pembayaran"><i class="fa fa-dollar"></i></button>
                            <!-- <a href="<?= base_url("sales/edit/$dt->id"); ?>" class="btn btn-warning btn-icon btn-xs edit" title="Ubah"><i class="fa fa-pencil"></i></a> -->
                            <button type="button" onclick="cancel('<?= $dt->id; ?>')" class="btn btn-danger btn-icon btn-xs cancel" title="Batal"><i class="fa fa-times-circle"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>