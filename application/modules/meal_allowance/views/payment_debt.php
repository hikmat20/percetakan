<div class="row mb-3">
    <div class="col-md-3">
        <label for="" class="form-label fw-bold text-secondary">Karyawan</label>
    </div>
    <div class="col-md-6">
        <input type="hidden" readonly name="id" id="id" class="form-control" value="">
        <input type="hidden" readonly name="employee_id" id="employee_id" class="form-control" value="<?= $cashReceipt->id; ?>">
        <input type="text" readonly id="employee_name" class="form-control" value="<?= $cashReceipt->employee_name; ?>">
        <small class="form-text text-danger invalid-feedback">Id Karyawan tidak valid</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <label for="" class="form-label fw-bold text-secondary">Tanggal</label>
    </div>
    <div class="col-md-6">
        <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d'); ?>">
        <small class="form-text text-danger invalid-feedback">Pilih nama Karyawan</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <label for="" class="form-label fw-bold text-secondary">Jumlah Bayar Kasbon</label>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input name="payment_value" id="payment_value" class="form-control text-end numeric currency" autocomplete="off" placeholder="0">
            <small class="form-text text-danger invalid-feedback">Isi jumlah bayar kasbon</small>
        </div>
    </div>
</div>
<hr>
<div class="row mb-3">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-primary" id="savePaymentReceipt"><i class="fa fa-save"></i> Simpan Pembayaran</button>
    </div>
</div>