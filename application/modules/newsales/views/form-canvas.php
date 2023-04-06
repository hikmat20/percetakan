<input type="hidden" id="form_type" value="<?= $form_type; ?>">
<input type="hidden" name="service" id="service" class="form-control form-control-sm" value="">
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
  <div class="col-lg-4">
    <label for="" class="form-label text-primary">QTY</label>
    <div class="input-group input-group-sm">
      <input type="number" class="form-control numeric text-end form-control-sm" min="0" id="qty" name="qty" placeholder="0">
      <span class="input-group-text">pcs</span>
    </div>
  </div>
</div>

<div class="mb-2">
  <div class="d-none custom_price">
    <span class="text-muted">
      Harga (/cm) : Rp. <span class="unit_price text-primary"></span> | Min: <span class="min_order text-primary"></span> cm
    </span>
    <input type="hidden" name="unit_price" id="unit_price">
  </div>
</div>

<div class="mb-2" id="custome_size" style="display: none;">
  <label for="" class="form-label text-primary">Ukuran</label>
  <div class="input-group input-group-sm">
    <input type="number" min="0.5" name="length" class="form-control form-control-sm" placeholder="Panjang" id="length">
    <span class="input-group-text">x</span>
    <input type="number" min="0.5" name="width" class="form-control form-control-sm" placeholder="Lebar" id="width">
    <span class="input-group-text">=</span>
    <input type="text" readonly name="total_size" class="form-control form-control-sm" placeholder="Luas" id="total_size">
    <span class="input-group-text">m</span>
  </div>
</div>

<div class="row mb-2">
  <div class="col-lg-8">
    <label for="" class="form-label">Harga</label>
    <div class="input-group input-group-sm">
      <span class="input-group-text">@</span>
      <input type="text" readonly name="price" class="form-control text-end form-control-sm" id="price" placeholder="0">
      <span class="input-group-text">=</span>
      <input type="text" id="total_price" name="total_price" readonly class="form-control text-end form-control-sm total_price" placeholder="0">
    </div>
  </div>
  <div class="col-lg-4">
    <label for="" class="form-label">Diskon</label>
    <div class="input-group input-group-sm">
      <input type="text" class="form-control text-end form-control-sm currency numeric" id="discount" name="discount" placeholder="0">
    </div>
  </div>
</div>

<div class="mb-2">
  <label class="form-check-label" for="cek_finishing">Finishing</label>
  <div class="mt-2">
    <input type="radio" class="btn-check" name="finishing_notes" value="Tanpa Laminating" id="tanpa-laminating" autocomplete="off">
    <label class="btn btn-sm btn-outline-primary" for="tanpa-laminating">Tanpa Laminating</label>

    <input type="radio" class="btn-check" name="finishing_notes" value="Laminating Glossy" id="laminating-glossy" autocomplete="off">
    <label class="btn btn-sm btn-outline-primary" for="laminating-glossy">Laminating Glossy</label>

    <input type="radio" class="btn-check" name="finishing_notes" value="Laminating Doff" id="laminating-doff" autocomplete="off">
    <label class="btn btn-sm btn-outline-primary" for="laminating-doff">Laminating Doff</label>
  </div>
</div>

<div class="mb-2">
  <label class="form-label" for="">Nama File </label>
  <input class="form-control form-control-sm " min="0" placeholder="Nama File" type="text" name="file_name" id="file_name">
</div>

<div class="mb-2">
  <label for="notes" class="form-label">Catatan :</label>
  <textarea class="form-control form-control-sm" name="notes" id="notes" rows="3"></textarea>
</div>

<script>
  $(document).ready(function() {
    $('.select').select2({
      theme: "bootstrap-5",
      placeholder: '~ Pilih ~',
      dropdownParent: $('#serviceModal'),
      width: '100%',
      allowClear: true,
      selectionCssClass: "select2--small", // For Select2 v4.1
      dropdownCssClass: "select2--small",
    })
  })
</script>