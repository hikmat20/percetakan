<input type="hidden" id="form_type" value="">
<input type="hidden" name="category_id" id="category_id" class="form-control form-control-sm" value="">
<div class="row">
  <div class="col-lg">
    <div class="mb-3 row">
      <div class="col-lg-8">
        <label for="" class="form-label text-primary">Barang</label>
        <style>
          .select2-results__group {
            font-weight: 700 !important;
            color: black !important;
          }
        </style>
        <select class="form-select form-select-sm select" name="item" id="item">
          <option value=""></option>
          <?php foreach ($stationery as $stt) : ?>
            <option class="text-primary" value="<?= $stt->id; ?>"> &nbsp;<?= $stt->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="row mb-2">
        <div class="col-md-8">
          <label for="" class="form-label">Harga</label>
          <div class="input-group input-group-sm mb-1">
            <span class="input-group-text">Rp.</span>
            <input type="hidden" readonly name="unit_price" class="form-control text-end form-control-sm" id="unit_price" placeholder="0">
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
            <input type="number" class="form-control text-center numeric form-control-sm" min="0" id="qty_stt" name="qty" placeholder="0" autocomplete="off">
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

      <div class="mt-2">
        <label class="form-label" for="">Nama File / Pesanan</label>
        <input class="form-control form-control-sm " min="0" placeholder="Nama File" type="text" name="file_name" id="file_name">
      </div>
    </div>

    <div class="mb-3">
      <label for="notes" class="form-label">Catatan/Keterangan :</label>
      <textarea class="form-control form-control-sm" name="notes" id="notes" rows="3"></textarea>
    </div>
    <div class="mb-3" id="list-wholesale"></div>
    <!-- <div class="mb-3">
     
    </div> -->

    <!-- <div class="row mb-3">
      <div class="col-lg-3">
        <div class="form-check form-switch">
          <input class="form-check-input" value="Y" name="flag_laminating" type="checkbox" id="cek_laminating">
          <label class="form-check-label" for="cek_laminating">Laminating</label>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="row" id="laminating" style="display: none;">
          <div class="col-lg-4">
            <select name="type_laminating" id="input-laminating" class="form-select form-select-sm">
              <option value="">~ Pilih ~</option>
              <?php foreach ($laminating as $lam) : ?>
                <option value="<?= $lam->id; ?>"><?= $lam->name; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-lg-4">
            <div class="input-group input-group-sm">
              <input class="form-control text-end" placeholder="0" type="hidden" name="price_laminating" id="price_laminating">
              <input class="form-control text-end numeric" min="0" placeholder="0" type="number" name="qty_laminating" id="qty_laminating">
              <span class="input-group-text">lbr</span>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="input-group input-group-sm">
              <input class="form-control text-end" readonly placeholder="0" type="text" name="total_price_laminating" id="total_price_laminating">
            </div>
          </div>

        </div>
      </div>

    </div> -->

    <!-- <div class="row">
      <div class="col-lg-3">
        <div class="form-check form-switch mb-3">
          <input class="form-check-input" value="Y" type="checkbox" id="cek_cutting">
          <label class="form-check-label" for="cek_cutting">Cutting </label>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="row" id="cutting" style="display: none;">
          <div class="col-lg-4">
            <div class="input-group input-group-sm">
              <input class="form-control text-end numeric" min="0" placeholder="0" type="number" name="qty_cutting" id="qty_cutting">
              <span class="input-group-text">lbr</span>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="input-group input-group-sm">
              <input class="" readonly placeholder="0" type="hidden" id="cut_id" value="<?= $cutting->id; ?>">
              <input class="form-control form-control-sm text-end" readonly placeholder="0" type="text" name="price_cutting" id="price_cutting">
              <span class="input-group-text">/lbr</span>
            </div>
          </div>
          <div class="col-lg-4 mb-3">
            <div class="input-group input-group-sm">
              <input class="form-control text-end" readonly placeholder="0" type="text" name="total_price_cutting" id="total_price_cutting">
            </div>
          </div>
          <div class="col-lg-12">
            <textarea id="input-cutting" name="cutting_note" placeholder="Keterangan" class="form-control form-control-sm"></textarea>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.select').select2({
      theme: "bootstrap-5",
      placeholder: '~ Pilih ~',
      width: '100%',
      dropdownParent: $('#ModalForm'),
      allowClear: true,
      selectionCssClass: "select2--small", // For Select2 v4.1
      dropdownCssClass: "select2--small",
    })
  })
</script>