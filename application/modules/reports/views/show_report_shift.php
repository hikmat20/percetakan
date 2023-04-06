<div class="row">
  <div class="col-md-6">
    <label class="form-label">Nama Kasir</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end fw-bold">
      <span><?= ($shift->username) ?: '~'; ?></span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Mulai Shift</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <span><?= ($shift->start_shift) ?: '~'; ?></span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Uang Masuk</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span><?= ($shift->qty_income) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Uang Keluar</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span><?= ($shift->qty_expense) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Transaksi</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span><?= ($shift->qty_transactions) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Produk Terjual</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span><?= ($shift->qty_sales_product) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<div class="row mt-5">
  <div class="col-md-6">
    <label class="form-label fw-bold h4">Saldo</label>
  </div>
  <div class="col-md-6">
  </div>
</div>
<hr>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Saldo Awal</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span>Rp. <?= (number_format($shift->beginning_balance)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Total Penjualan</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span>Rp. <?= (number_format($shift->cash_sales)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label class="form-label fw-bold">Perkiraan Saldo Akhir</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span>Rp. <?= (number_format($shift->expected_ending_balance)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Pembayaran Tunai</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span>Rp. <?= (number_format($shift->cash_payment)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Total Uang Masuk</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span>Rp. <?= (number_format($shift->income)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <label class="form-label">Total Uang Keluar</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span>Rp. <?= (number_format($shift->expenses)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-md-6">
    <label class="form-label fw-bold">Saldo Akhir</label>
  </div>
  <div class="col-md-6">
    <div class="d-grid text-end">
      <a href="javascript:void(0)" class="btn-link text-secondary">
        <span>Rp. <?= (number_format($shift->ending_balance)) ?: '0'; ?> <i data-feather="chevron-right"></i></span>
      </a>
    </div>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-md-12">
    <div class="d-grid">
      <a href="<?= base_url('shift/report_shift/') . $shift->id; ?>" id="print_report_shift" class="btn btn-outline-secondary">Cetak Laporan Shift</a>
    </div>
  </div>
</div>