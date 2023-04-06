<form id="form-payment" enctype="multipart/form-data">
    <div class="modal-header justify-content-between">
        <h2 class="text-danger">Rp. </h2>
        <h2 class="text-danger"><?= number_format($trans->balance); ?>,-</h2>
        <input type="hidden" name="balance" id="sisa_tagihan" value="<?= $trans->balance; ?>">
        <input type="hidden" name="trans_id" value="<?= $trans->id; ?>">
    </div>
    <div class="modal-body">
        <div class="py-0 border-0">
            <h4 class="">Total Pembayaran</h4>
        </div>
        <div class="py-2">
            <table id="data_payment" class="table table-sm table-borderless table-condensed">
                <thead class="bg-light" style="font-size: 12px;">
                    <td class="fw-bolder">Jns. Bayar</td>
                    <td class="fw-bolder">Jns Pembayaran</td>
                    <td class="fw-bolder">Noninal</td>
                </thead>
                <tbody>
                    <?php
                    if (!$payment) : ?>
                        <tr>
                            <td colspan="3" class="text-center"><small><i>Belum ada pembayaran</i></small></td>
                        </tr>
                        <?php else :
                        foreach ($payment as $pay) : ?>
                            <tr>
                                <td><?= $pay->payment_methode_name; ?></td>
                                <td><?= $pay->payment_type_name; ?></td>
                                <td><?= number_format($pay->payment_value); ?></td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
        <hr>
        <div id="input_bayar">
            <div class="py-0 border-0">
                <h4 class="">Input Pembayaran</h4>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Jenis Bayar</label>
                <div class="mx-auto">
                    <?php foreach ($payment_type as $pt) : ?>
                        <input type="radio" class="btn-check btn-block" data-full_value="<?= $pt->full_value; ?>" name="payment_type" value="<?= $pt->id; ?>" id="<?= $pt->id; ?>" autocomplete="off">
                        <label class="btn btn-outline-danger btn-sm btn-block " style="width: 100px;" for="<?= $pt->id; ?>"><?= $pt->name; ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Jenis Pembayaran</label>
                <div class="mx-auto mb-3">
                    <?php foreach ($payment_methode as $pm) : ?>
                        <input type="radio" class="btn-check btn-block payment-methode" data-need_document="<?= $pm->need_document; ?>" name="payment_methode" value="<?= $pm->id; ?>" id="<?= $pm->id; ?>" autocomplete="off">
                        <label class="btn btn-outline-success btn-sm btn-block mb-1" style="width: 100px;" for="<?= $pm->id; ?>"><i class="<?= $pm->icon; ?>"></i> <?= $pm->name; ?></label>
                    <?php endforeach; ?>
                </div>
                <div class="upload_document mb-3"></div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Nominal Pembayaran</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" autocomplete="off" name="payment_value" class="form-control text-end currency fs-3" id="payment_value" aria-describedby="helpId" placeholder="0">
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal-footer d-grid" style="justify-content: unset;">
    <div class="row">
        <div class="col-md-3 offset-3 d-grid px-1">
            <button type="button" data-id="<?= $trans->id; ?>" class="btn btn-primary rounded-pill" id="save_payment"> <i data-feather="dollar-sign" style="height: 0.95rem;margin-top: -3px;margin-right: px;"></i> Bayar</button>
        </div>
        <div class="col-md-3 d-grid px-1">
            <button type="button" class="btn btn-outline-primary rounded-pill" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>