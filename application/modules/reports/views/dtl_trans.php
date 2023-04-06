<div class="row">
  <div class="col-md-6">
    <div class="row mb-2">
      <label class="col-md-4">No. Trans</label>
      <div class="col-md-8">: <?= $header->id; ?></div>
    </div>
    <div class="row mb-2">
      <label class="col-md-4">Pelanggan</label>
      <div class="col-md-8">: <?= $header->customer_name; ?></div>
    </div>
    <div class="row mb-2">
      <label class="col-md-4">Telp.</label>
      <div class="col-md-8">: <?= $header->phone; ?></div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row mb-2">
      <label class="col-md-4">Tanggal</label>
      <div class="col-md-8">: <?= $header->date; ?></div>
    </div>
    <div class="row mb-2">
      <label class="col-md-4">Kasir</label>
      <div class="col-md-8">: <?= $header->cashier_name; ?></div>
    </div>
    <div class="row mb-2">
      <label class="col-md-4">Status</label>
      <div class="col-md-8">: <?= $sts[$header->status]; ?></div>
    </div>
  </div>
</div>

<hr>
<?php $n = $subtotal = $diskon = $grand_total = 0;
foreach ($detail as $dtl) : $n++;
  $subtotal     +=  $dtl->subtotal;
  $diskon       +=  $dtl->discount;
  $grand_total  +=  $dtl->grand_total;
?>
  <div class="card-body bg-gray-100 p-2 mt-2">
    <div class="row m-0">
      <div class="col-1">
        <?= $n; ?>
      </div>
      <div class="col-sm-5 px-1 m-0">
        <strong><?= $dtl->product_name; ?></strong> |
        <i><?= $dtl->products_detail_name; ?></i><br>
        <?php if ($dtl->subtotal_size) : ?>
          <span><?= $dtl->length . 'x' . $dtl->width . '=' . $dtl->subtotal_size . $dtl->unit ?> </span><br>
        <?php endif; ?>
        <?php if ($dtl->file_name) : ?>
          <small><i class="fa fa-file-pdf-o"></i> <?= $dtl->file_name; ?></small>
        <?php endif; ?>
      </div>
      <div class="col-sm-2 px-1 m-0 text-end">
        <strong><?= number_format($dtl->price); ?></strong><br>
        <?php if ($dtl->unit_price) : ?>
          <small>@<?= number_format($dtl->unit_price); ?></small><br>
        <?php endif; ?>
      </div>
      <div class="col-sm-1 px-1 m-0 text-end">
        <strong><?= $dtl->qty; ?></strong>
      </div>
      <div class="col-sm-2 px-1 m-0 text-end">
        <strong class="text-primary"><?= number_format($dtl->grand_total); ?></strong>
        <?php if ($dtl->discount > 0) : ?>
          <small class="text-decoration-line-through"><?= number_format($dtl->subtotal); ?></small><br>
          <small class="text-danger">-<?= number_format($dtl->discount); ?></small><br>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<hr>
<div class="d-flex justify-content-between">
  <h5 class="">Subtotal</h5>
  <h5 class="text-end"><span class="subtotal"><?= ($subtotal) ? number_format($subtotal) : 0; ?></span>,-</h5>
</div>
<div class="discount_data ps-1">
  <div class="d-flex justify-content-between">
    <h5 class="text-muted">Diskon</h5>
    <h5 class=" text-muted text-end"><span class="discount_cost">-<?= ($diskon) ? number_format($diskon) : 0; ?></span>,-</h5>
  </div>
</div>
<div class="d-flex justify-content-between">
  <h3 class="fw-bold text-primary">Grand Total</h3>
  <h3 class="fw-bold text-end text-primary"><span><?= ($grand_total) ? number_format($grand_total) : 0; ?></span>,-</h3>
</div>
<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item bg-white">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button p-0 bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        Detail
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body px-1">
        <div class="d-flex justify-content-between">
          <h6 class="text-success ">Bayar</h6>
          <h6 class="text-end text-success "><span><?= ($header && $header->total_payment) ? number_format($header->total_payment) : 0; ?></span>,-</h6>
        </div>
        <div class="d-flex justify-content-between">
          <h6 class="text-warning ">Kembalian</h6>
          <h6 class="text-end text-warning "><span><?= ($header && $header->return) ? number_format($header->return) : 0; ?></span>,-</h6>
        </div>
        <div class="d-flex justify-content-between">
          <h6 class="text-danger">Sisa</h6>
          <h6 class="text-end text-danger"><span><?= ($header && $header->balance) ? number_format($header->balance) : 0; ?></span>,-</h6>
        </div>
      </div>
    </div>
  </div>
</div>