<?php if (isset($data->id)) {
  $type = 'edit';
} ?>
<div class="">
  <form id="frm_menus">
    <div class="card-body">
      <input type="hidden" id="type" name="type" value="<?= isset($type) ? $type : 'add' ?>">
      <input type="hidden" id="id" name="id" value="<?php echo set_value('id', isset($data->id) ? $data->id : ''); ?>">

      <div class="row">
        <div class="col-lg-6">
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-3 col-form-label">ID Menu</label>
            <div class="col-sm-9">
              <input type="text" class="form-control form-control-sm" id="id" name="id" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="4" value="<?php echo set_value('id', isset($data->id) ? $data->id : ''); ?>" placeholder="ID menu" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Nama Menu</label>
            <div class="col-sm-9">
              <input type="text" class="form-control form-control-sm" id="title" name="title" maxlength="45" value="<?php echo set_value('title', isset($data->title) ? $data->title : ''); ?>" placeholder="Menu's Name" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Path</label>
            <div class="col-sm-9">
              <input type="text" class="form-control form-control-sm" id="link" name="link" value="<?php echo set_value('link', isset($data->link) ? $data->link : ''); ?>" placeholder="Link" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Menu Utama</label>
            <div class="col-sm-9">
              <select name="parent_id" id="parent_id" class="select2 form-control form-control-sm">
                <option value="">~ Pilih ~</option>
                <?php foreach ($parents as $prn) : ?>
                  <option value="<?= $prn->id; ?>" <?= ($data && $data->parent_id == $prn->id) ? 'selected' : ''; ?>><?= $prn->title; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Icon</label>
            <div class="col-sm-9">
              <input type="text" class="form-control form-control-sm icp-auto" id="icon" name="icon" value="<?php echo set_value('icon', isset($data->icon) ? $data->icon : ''); ?>" placeholder="Icon menu" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Target</label>
            <div class="col-sm-9">
              <select id="target" name="target" class="form-control form-control-sm">
                <option value="">~ Pilih ~</option>
                <option value="_blank" <?= set_select('target', '_blank', isset($data->target) && $data->target == '_blank'); ?>>Blank
                </option>
                <option value="sametab" <?= set_select('target', 'sametab', isset($data->target) && $data->target == 'sametab'); ?>>Same Tab
                </option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-9">
              <select id="status" name="status" class="form-control form-control-sm">
                <option value="">~ Pilih ~</option>
                <option value="1" <?= set_select('status', '1', isset($data->status) && $data->status == '1'); ?>>Active
                </option>
                <option value="0" <?= set_select('status', '0', isset($data->status) && $data->status == '0'); ?>>Inactive
                </option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-3 col-form-label">Urutan</label>
            <div class="col-sm-9">
              <input type="text" class="form-control form-control-sm" id="order" name="order" value="<?php echo set_value('order', isset($data->order) ? $data->order : ''); ?>" placeholder="order menu" required>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>