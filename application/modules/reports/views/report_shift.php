<h2>Laporan Shift</h2>
<div class="card">
  <div class="card-body" id="data_report">
    <div class="mb-3">
      <div class="row">
        <label for="" class="form-label col-lg-1 control-label">Tanggal :</label>
        <div class="col-md-4">
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            <input type="text" class="form-control daterange" name="sdate" id="dates" placeholder="" aria-label="" value="">
            <button class="btn btn-primary" id="getData" type="button" aria-label="">Tampil</button>
            <button class="btn btn-warning" onclick="location.href=siteurl+controller+'shift'" type="button" aria-label=""><i class="fa fa-refresh"></i> Reset</button>
          </div>
        </div>
      </div>
    </div>

    <table class="table-condensed table table-sm table-hover" width="100%" id="list_shift">
      <thead class="table-primary">
        <tr class="">
          <th scope="col">No</th>
          <th class="text-center" scope="col">Tanggal</th>
          <th class="text-center" scope="col">Kasir</th>
          <th class="text-center" scope="col">Mulai Shift</th>
          <th class="text-center" scope="col">Tutup Shift</th>
          <th class="text-center" scope="col">Ditutup Oleh</th>
          <th class="text-right" scope="col">Total Perkiraan</th>
          <th class="text-right" scope="col">Total Akhir</th>
          <th class="text-right" scope="col">Total Aktual</th>
          <th class="text-center" scope="col">Lihat</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($records) :
          $n = 0;
          foreach ($records as $r) : $n++;
        ?>
            <tr>
              <th scope="row"><?= $n; ?></th>
              <td><?= $r->date; ?></td>
              <td class="text-center"><?= $r->full_name; ?></td>
              <td class="text-center"><?= $r->start_shift; ?></td>
              <td class="text-center"><?= $r->end_shift; ?></td>
              <td class="text-center"><?= $r->ending_by; ?></td>
              <td class="text-end"><?= number_format($r->expected_ending_balance); ?></td>
              <td class="text-end"><?= number_format($r->ending_balance); ?></td>
              <td class="text-end"><?= number_format($r->actual_ending_balance); ?></td>
              <td class="text-center"><button type="button" data-id="<?= $r->id; ?>" data-bs-toggle="modal" data-bs-target="#modelId" class="btn btn-light-secondary btn-icon btn-xs show_data"><i class="fa fa-eye"></i></button></td>
            </tr>
          <?php endforeach;
        else :
          ?>
      <tbody>
        <tr class="border-bottom">
          <td colspan="10" class="text-center">Tidak ada data</td>
        </tr>
      </tbody>
    <?php endif; ?>
    </tbody>
    </table>
  </div>
  <!-- <div class="card-footer">
    <div class="text-end">
      <button type="button" onclick="print($('#data_report'))" class="btn btn-danger"><i class="fa fa-print"></i> Print</button>
    </div>
  </div> -->
</div>

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="view_data">
        Data tidak tersedia
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('input[name="sdate"]').daterangepicker();
  })

  $(document).on('click', '#getData', function() {
    let dates = $('#dates').val();
    let split = dates.split(' - ');
    console.log(split);
    var sDate = split[0]
    var eDate = split[1]
    sDate = sDate.replaceAll('/', '-');
    eDate = eDate.replaceAll('/', '-');
    $('table#list_shift tbody').load(siteurl + controller + 'shift/' + sDate + "/" + eDate)
  })

  $(document).on('click', '.show_data', function() {
    let id = $(this).data('id');
    $('.modal-title').html('Laporan Shift')
    $('#view_data').load(siteurl + controller + 'show_data_shift/' + id)
  })
</script>