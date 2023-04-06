<input type="hidden" id="form_type" value="<?= $form_type; ?>">
<div class="mb-3">
  <div class="mb-3 row">
    <div class="col-lg-6">
      <div class="mb-3 row">
        <div class="col-lg-6">
          <label for="" class="form-label text-primary">Ukuran</label>
          <select class="form-select form-select-sm select" name="material" id="material">
            <option value=""></option>
            <?php foreach ($materials as $mtr) : ?>
              <option value="<?= $mtr->id; ?>"><?= $mtr->name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3">
          <div class="form-label">
            <label class="text-primary">Harga</label>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="row">
            <div class="col-lg-4">
              <div class="input-group input-group-sm">
                <input type="text" readonly name="price" class="form-control text-end form-control-sm" id="price" placeholder="0">
                <span class="input-group-text">/pcs</span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="input-group input-group-sm">
                <input type="number" class="form-control numeric text-end form-control-sm" min="0" id="qty" name="qty" placeholder="0">
                <span class="input-group-text">pcs</span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="input-group input-group-sm">
                <input type="text" id="total_price" name="total_price" readonly class="form-control text-end form-control-sm total_price" placeholder="0">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3">
          <div class="form-check form-switch">
            <input class="form-check-input" value="Y" name="flag_additional" type="checkbox" id="cek_additional">
            <label class="form-check-label" for="cek_additional">Laminating</label>
          </div>
        </div>

        <div class="col-lg-9">
          <div class="row" id="additional" style="display: none;">
            <div class="col-lg-4">
              <select name="type_additional" id="input-additional" class="form-select form-select-sm">
                <option value="">~ Pilih ~</option>
                <option value="03">Laminating Doff - Rp. 2000,-</option>
                <option value="04">Laminating Glossy - Rp. 2000,-</option>
              </select>
            </div>

            <div class="col-lg-4">
              <div class="input-group input-group-sm">
                <input class="form-control text-end" placeholder="0" type="hidden" name="price_additional" id="price_additional">
                <input class="form-control text-end numeric" min="0" placeholder="0" type="number" name="qty_additional" id="qty_additional">
                <span class="input-group-text">lbr</span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="input-group input-group-sm">
                <input class="form-control text-end" readonly placeholder="0" type="text" name="total_price_additional" id="total_price_additional">
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-lg-3">
          <div class="form-check form-switch">
            <input class="form-check-input" value="Y" name="flag_additional2" type="checkbox" id="cek_additional2">
            <label class="form-check-label" for="cek_additional2">Kertas BC</label>
          </div>
        </div>

        <div class="col-lg-9">
          <div class="row" id="additional2" style="display: none;">
            <div class="col-lg-4">
              <input class="form-control form-control-sm text-end" placeholder="0" type="text" readonly name="price_additional2" id="price_additional2">
            </div>

            <div class="col-lg-4">
              <div class="input-group input-group-sm">
                <input class="form-control text-end numeric" min="0" placeholder="0" type="number" name="qty_additional2" id="qty_additional2">
                <span class="input-group-text">lbr</span>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="input-group input-group-sm">
                <input class="form-control text-end" readonly placeholder="0" type="text" name="total_price_additional2" id="total_price_additional2">
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="">
          <label class="form-label" for="">Nama File </label>
          <input class="form-control form-control-sm " min="0" placeholder="Nama File" type="text" name="file_name" id="file_name">
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="row mb-3">
        <div class="col-lg-3">
          <label for="" class="form-label">Diskon</label>
          <div class="input-group input-group-sm">
            <input type="text" class="form-control text-end form-control-sm currency numeric" id="discount" name="discount" placeholder="0">
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="notes" class="form-label">Catatan :</label>
        <textarea class="form-control form-control-sm" name="notes" id="notes" rows="3"></textarea>
      </div>

      <div class="mb-3">
        <div class="card">
          <div class="card-body">
            <!-- <h3 for="" class="form-label">Total</h3> -->
            <div class="input-group d-none">
              <span class="input-group-text">Rp.</span>
              <input type="text" readonly class="form-control text-sm text-end" id="total" name="total" placeholder="0">
            </div>
            <div class="d-flex justify-content-between">
              <h5 class="">Total</h5>
              <h5 class="text-end"><span class="total">0</span>,-</h5>
            </div>
            <div class="laminating_cost_data ps-3" style="display: none;">
              <div class="d-flex justify-content-between">
                <h6 class="text-muted ">Laminating</h6>
                <h6 class="text-muted text-end"><span class="laminating_cost ">0</span>,-</h6>
              </div>
            </div>
            <div class="cutting_cost_data ps-3" style="display: none;">
              <div class="d-flex justify-content-between">
                <h6 class="text-muted ">Cutting</h6>
                <h6 class="text-muted text-end"><span class="cutting_cost ">0</span>,-</h6>
              </div>
            </div>
            <div class="additional_data ps-3" style="display: none;">
              <div class="d-flex justify-content-between">
                <h6 class="text-muted">Tambahan Mika</h6>
                <h6 class=" text-muted text-end"><span class="additional_cost ">0</span>,-</h6>
              </div>
            </div>
            <div class="additional_data2 ps-3" style="display: none;">
              <div class="d-flex justify-content-between">
                <h6 class="text-muted">Kertas BC</h6>
                <h6 class=" text-muted text-end"><span class="additional_cost2 ">0</span>,-</h6>
              </div>
            </div>
            <div class="discount_data ps-3" style="display: none;">
              <div class="d-flex justify-content-between">
                <h6 class="text-muted">Diskon</h6>
                <h6 class=" text-muted text-end"><span class="discount_cost ">0</span>,-</h6>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <h4 class=" text-success">Grand Total</h4>
              <h4 class="text-end text-success"><span class="total_trans">0</span>,-</h4>
            </div>
            <div class="input-group d-none">
              <span class="input-group-text">Rp.</span>
              <input type="text" readonly class="form-control text-sm text-end" id="total_trans" name="total_trans" placeholder="0">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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