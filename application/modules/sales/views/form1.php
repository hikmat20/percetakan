<input type="hidden" id="form_type" value="">
<input type="hidden" name="service" id="service" class="form-control form-control-sm" value="">
<div class="">
  <div class="row mb-2">
    <div class="col-lg-8">
      <label for="" class="form-label text-primary">Bahan</label>
      <select class="form-select form-select-sm select" name="material" id="material">
        <option value="">~ Pilih Bahan ~</option>
        <?php foreach ($materials as $mtr) : ?>
          <option value="<?= $mtr->id; ?>"><?= $mtr->name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <div class="d-none custom-size">
        <label for="" class=" form-label text-primary">Harga (/<span class="unit"></span>)</label>
        <input type="hidden" name="unit" id="unit">
        <div class="input-group input-group-sm">
          <span class="input-group-text">Rp.</span>
          <input type="text" readonly name="unit_price" class="form-control text-end form-control-sm" id="unit_price" placeholder="0">
        </div>
      </div>
    </div>
  </div>

  <div class="mb-2 d-none custom-size">
    <div class="row">
      <div class="col-md-8">
        <label for="" class="form-label text-primary">Ukuran</label>
        <div class="input-group input-group-sm">
          <input type="number" name="length" min="0" class="form-control form-control-sm text-end" placeholder="Panjang" id="length">
          <span class="input-group-text">x</span>
          <input type="number" name="width" min="0" class="form-control form-control-sm text-end" placeholder="Lebar" id="width">
          <span class="input-group-text">=</span>
          <input type="text" readonly min="0" name="subtotal_size" class="form-control form-control-sm text-end" placeholder="Luas" id="subtotal_size">
          <span class="input-group-text unit"></span>
        </div>
      </div>
      <div class="col-md-4">
        <label for="" class="form-label text-primary">Total Ukuran</label>
        <div class="input-group input-group-sm">
          <input type="text" readonly min="0" name="total_size" class="form-control form-control-sm text-end" placeholder="Luas" id="total_size">
          <span class="input-group-text unit"></span>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-2">
    <div class="col-md-8">
      <label for="" class="form-label">Harga</label>
      <div class="input-group input-group-sm mb-1">
        <span class="input-group-text">Rp.</span>
        <input type="text" readonly name="price" class="form-control text-end form-control-sm currency" id="price" placeholder="0">
      </div>
      <div class="form-check form-switch ">
        <input class="form-check-input" type="checkbox" id="change_price">
        <label class="form-check-label" for="change_price">Ubah Harga</label>
      </div>
    </div>
    <div class="col-md-4">
      <label for="" class="form-label text-primary">QTY</label>
      <div class="input-group input-group-sm">
        <input type="number" class="form-control text-center numeric form-control-sm" min="0" id="qty" name="qty" placeholder="0" autocomplete="off">
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-md-8">
      <label for="" class="form-label text-primary">Subtotal</label>
      <div class="input-group input-group-sm">
        <span class="input-group-text">Rp.</span>
        <input type="text" id="total_price" name="total_price" readonly class="form-control text-end form-control-sm total_price" placeholder="0">
      </div>
    </div>
    <div class="col-md-4">
      <label for="" class="form-label">Diskon</label>
      <div class="input-group input-group-sm">
        <span class="input-group-text">Rp.</span>
        <input type="text" class="form-control text-end form-control-sm currency numeric" id="discount" name="discount" placeholder="0">
      </div>
    </div>
  </div>

  <div class="mb-2 <?= ($finishing) ? '' : 'd-none'; ?> ">
    <label for="" class="form-label">Finishing</label>
    <div class="finishing-type">
      <?php foreach ($finishing as $fin) : ?>
        <input type="radio" class="btn-check" name="finishing_notes" value="<?= $fin->name; ?>" id="<?= $fin->id; ?>" autocomplete="off">
        <label class="btn btn-sm btn-outline-primary" for="<?= $fin->id; ?>"><?= $fin->name; ?></label>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="mb-2">
    <label for="" class="form-label">Nama File / Pesanan</label>
    <div class="input-group input-group-sm">
      <span class="input-group-text"><i class="fa fa-file-o"></i></span>
      <input type="text" name="file_name" class="form-control form-control-sm" id="file_name" placeholder="Nama file">
    </div>
  </div>

  <div class="mb-2">
    <label for="notes" class="form-label">Catatan/Keterangan : </label>
    <textarea class="form-control form-control-sm" name="notes" id="notes" placeholder="Keterangan tambahan ..." rows="3"></textarea>
  </div>

  <div class="mb-3" id="list-wholesale"></div>
  <div class="mb-3" id="information"></div>
</div>

<script>
  $(document).ready(function() {
    $('.select').select2({
      theme: "bootstrap-5",
      placeholder: '~ Pilih ~',
      dropdownParent: $('#ModalForm'),
      width: '100%',
      allowClear: true,
      selectionCssClass: "select2--small", // For Select2 v4.1
      dropdownCssClass: "select2--small",
    })
  })
</script>