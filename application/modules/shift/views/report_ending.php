<div class="row mb-3">
  <div class="col-md-12">
    <div class="alert alert-secondary text-center" role="alert">
      <strong>SHIFT BERAKHIR</strong>
    </div>

  </div>
</div>
<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label">Nama Kasir</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end fw-bold">
      <span><?= ($shift->username) ?: '~'; ?></span>
    </div>
  </div>
</div>
<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label">Mulai Shift</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <span><?= ($shift->start_shift) ?: '~'; ?></span>
    </div>
  </div>
</div>
<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label">Akhir Shift</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <span><?= ($shift->end_shift) ?: '0'; ?></span>
    </div>
  </div>
</div>
<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label">Diakhiri oleh</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <span><?= ($shift->ending_shift_user) ?: '~'; ?></span>
    </div>
  </div>
</div>
<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label fw-bold name">Jumlah Uang</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <span><?= number_format($shift->actual_ending_balance) ?: '0'; ?></span>
    </div>
  </div>
</div>
<hr>
<div class="row mb-3">
  <div class="col-md-6">
    <label class="form-label fw-bold name">Jumlah Uang</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <span><?= number_format($shift->actual_ending_balance) ?: '0'; ?></span>
    </div>
  </div>
</div>
<div class="row mb-3">
  <div class="col-md-6">
    <div class="d-grid">
      <a href="<?= base_url('shift/report_shift/') . $shift->id; ?>" target="_blank" class="btn btn-primary"><i data-feather="print"></i> Cetak Laporan Shift</a>
    </div>
  </div>
  <div class="col-md-6">
    <div class="d-grid">
      <button class="btn btn-danger" data-bs-dismiss="modal" onclick="location.reload()"><i data-feather="x"></i> Tutup</button>
    </div>
  </div>
</div>