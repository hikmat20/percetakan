<form id="form-customer">
    <input type="hidden" name="id" value="<?= ($data) ? $data->id : ''; ?>">
    <div class="mb-3">
        <label for="date" class="form-label">Tanggal Transaksi</label>
        <input type="date" name="date" id="date" class="form-control" value="<?= ($data) ? date_format(new DateTime($data->date), 'Y-m-d') : date('Y-m-d'); ?>">
    </div>
    <div class="mb-3">
        <label for="customer_name" class="form-label">Pelanggan</label>
        <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Nama Pelanggan" value="<?= ($data) ? $data->customer_name : ''; ?>">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Telepon</label>
        <input type="text" name="phone" id="phone" class="form-control" placeholder="08..." value="<?= ($data) ? trim($data->phone) : ''; ?>">
    </div>
    <div class="mt-6">
        <label for="phone" class="form-label"></label>
        <!-- <button type="button" class="btn btn-warning btn-sm " onclick="kembali()" id="back"><i class="fa fa-arrow-left"></i> Batal</button> -->
    </div>
</form>