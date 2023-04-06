<style>
    * {
        font-family: consolas;
        font-size: 12px;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .stretched-text {
        /* letter-spacing: 2px; */
        /* display: inline-block; */
        font-weight: bold;
        transform: scaleY(2);
        transform-origin: 0 0;
        margin-bottom: -50%;
    }
</style>
<div style="width: 7.8cm;" class="text-center">
    <table>
        <tr class="text-center">
            <td style="font-size: 18px; font-weight: bold;">SINAR DIGITAL PRINTING</td>
        </tr>
        <tr class="text-center">
            <td>Jl. Waru No. 7A-B, Rawamangun, Jak-Tim</td>
        </tr>
        <tr class="text-center">
            <td>WA : 0811-8826-272, 0811-9768-684"</td>
        </tr>
        <tr class="text-center">
            <td>Email : sinardigitalprinting2@gmail.com</td>
        </tr>
        <tr>
            <td>-------------------------------------------</td>
        </tr>
        <tr>
            <td>Kasir : <?= ucfirst($trans->created_by_name); ?> | OP : <?= ucfirst($trans->created_by_name); ?></td>
        </tr>
        <tr>
            <td>-------------------------------------------</td>
        </tr>
    </table>
    <table>
        <tr>
            <td width="20">No.</td>
            <td>: <?= $trans->id; ?></td>
        </tr>
        <tr>
            <td>Tgl/Jam</td>
            <td>: <?= $trans->date; ?></td>
        </tr>
        <tr>
            <td>Plg </td>
            <td>: <?= $trans->customer_name; ?></td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td>: <?= $trans->phone; ?></td>
        </tr>
        <tr>
            <td colspan="3">-------------------------------------------</td>
        </tr>
    </table>
    <table>
        <tr>
            <td>Brg.</td>
            <td class="text-right">Jml.</td>
            <td class="text-right">Harga</td>
            <td class="text-right" width="80">Subtotal</td>
        </tr>
        <tr>
            <td colspan="4">-------------------------------------------</td>
        </tr>

        <?php foreach ($details as $dtl) : ?>
            <tr>
                <td colspan="4"><?= $dtl->products_detail_name . (($dtl->width) ? " - " . $dtl->width . "x" . $dtl->length : ''); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="text-right"><?= $dtl->qty; ?></td>
                <td class="text-right"><?= number_format($dtl->price); ?></td>
                <td class="text-right"><?= number_format($dtl->subtotal); ?></td>
            </tr>
            <?php if ($dtl->discount > 0) : ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right">Disc.</td>
                    <td class="text-right"><?= "-" . number_format($dtl->discount); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="4">-------------------------------------------</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-right" colspan="2">Subtotal :</td>
            <td class="text-right"><?= number_format($trans->subtotal); ?></td>
        </tr>
        <?php if ($trans->discount) : ?>
            <tr>
                <td></td>
                <td class="text-right" colspan="2">Discount :</td>
                <td class="text-right"><?= number_format($trans->discount); ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td></td>
            <td class="text-right stretched-text" style="font-size: 16px;" colspan="2">Grand Total :</td>
            <td class="text-right stretched-text" style="font-size: 16px;"><?= number_format($trans->grand_total); ?></td>
        </tr>
    </table>
    <table>
        <?php foreach ($payment as $pay) : ?>
            <tr>
                <td></td>
                <td colspan="2" class="text-right">Pembayaran</td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td></td>
                <td class="text-right" colspan="2"><?= $pay->payment_type_name . " - " . $pay->payment_methode_name . " :"; ?></td>
                <td class="text-right"><?= number_format($pay->payment_value); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="text-right" colspan="2">Sisa :</td>
                <td class="text-right"><?= number_format($trans->balance); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="text-right" colspan="2">Kembalian :</td>
                <td class="text-right"><?= number_format($trans->return); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>