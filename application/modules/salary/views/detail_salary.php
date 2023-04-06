<hr>
<div class="row">
  <div class="col-md-6">
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-bold">Nama Karyawan</label>
      <input type="hidden" name="employee_id" value="<?= $employee->id; ?>">
      <div class="col-md-4">: <span class="fw-bold"> <?= $employee->employee_name; ?></span></div>
    </div>

    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Bagian</label>
      <div class="col-md-4">: <span class="fw-"> <?= $employee->position_name; ?></span></div>
    </div>
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Tgl Mulai Kerja</label>
      <div class="col-md-4">: <span class="fw-"> <?= $employee->hire_date; ?></span></div>
    </div>
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Libur /Bulan</label>
      <div class="col-md-4">
        <input type="hidden" name="leave_allowance" id="leave_allowance" value="<?= $employee->leave_allowance; ?>">
        : <span class="fw-"><?= $employee->leave_allowance; ?> Hari</span>
      </div>
    </div>

    <hr>
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Tanggal Terima</label>
      <div class="col-md-9">
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
          <input type="date" class="form-control" placeholder="YYYY-mm-dd" name="date" id="date">
          <span class="invalid-feedback text-red">Tanggal tidak boleh kosong!</span>
        </div>
      </div>
    </div>
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Periode Gaji</label>
      <div class="col-md-9">
        <div class="row">
          <div class="col-md-6">
            <label for="">Tanggal Mulai</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              <input type="date" class="form-control" placeholder="YYYY-mm-dd" name="sdate" id="sdate">
              <span class="invalid-feedback text-red">Periode gaji tidak boleh kosong!</span>
            </div>
          </div>
          <div class="col-md-6">
            <label for="">Tanggal Selesai</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              <input type="date" class="form-control" placeholder="YYYY-mm-dd" name="edate" id="edate">
              <!-- <select name="month" id="month" class="form-select select2 required">
            <option value="">~ Bulan ~</option>
            <?php for ($i = 1; $i <= count($month_name); $i++) : ?>
              <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT); ?>"><?= $month_name[str_pad($i, 2, '0', STR_PAD_LEFT)]; ?></option>
            <?php endfor ?>
          </select> -->
              <span class="invalid-feedback text-red">Periode gaji tidak boleh kosong!</span>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Jumah Hari</label>
      <div class="col-md-4">
        <input type="hidden" name="days_month" id="days_month" value="">
        : <span class="badge bg-info h5"><span id="text_days_month">-</span> Hari</span>
      </div>
    </div>

    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Total Libur</label>
      <div class="col-md-4">
        <div class="input-group">
          <input type="text" name="actual_leave" id="actual_leave" class="form-control text-end" placeholder="0">
          <span class="input-group-text">Hari</span>
          <span class="invalid-feedback text-red">Total libur tidak boleh kosong!</span>
        </div>
      </div>
    </div>
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Tidak Masuk Kerja</label>
      <div class="col-md-4">
        <div class="input-group">
          <input type="text" readonly name="not_pay_day" id="not_pay_day" class="form-control text-end" placeholder="0">
          <span class="input-group-text">Hari</span>
        </div>
      </div>
    </div>
    <hr>
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Gaji Pokok /Bulan</label>
      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-text">Rp.</span>
          <input type="text" class="form-control text-end currency" placeholder="0" name="monthly_salary" id="monthly_salary" value="<?= number_format($employee->monthly_salary); ?>">
        </div>
      </div>
      <div class="col-md-5">
        <div class="input-group">
          <span class="input-group-text">Harian</span>
          <span class="input-group-text">Rp.</span>
          <input type="text" readonly class="form-control text-end" placeholder="0" name="dayli_salary" id="dayli_salary" value="0">
        </div>
      </div>
    </div>

    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-">Masuk Kerja <small>(Pendapatan)</small></label>
      <div class="col-md-4">
        <div class="input-group">
          <input type="text" readonly name="work_days" id="work_days" class="form-control text-end" placeholder="0" value="">
          <span class="input-group-text">Hari</span>
        </div>
      </div>
      <div class="col-md-5">
        <div class="input-group">
          <span class="input-group-text">Potong</span>
          <span class="input-group-text">Rp.</span>
          <input type="text" readonly name="cut_salary" id="cut_salary" class="form-control text-end" placeholder="0" value="">
        </div>
      </div>
    </div>
    <hr>
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-bold h4">Total Gaji</label>
      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-text">Rp.</span>
          <input type="text" readonly class="form-control text-end" name="total_salary" id="total_salary" placeholder="0" value="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-check pt-2">
          <input class="form-check-input" type="checkbox" value="Y" id="check_pay_bon">
          <label class="form-check-label" for="check_pay_bon">
            Potong Bon
          </label>
        </div>
      </div>
    </div>

    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-bold h5">Potong Bon</label>
      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-text">Rp.</span>
          <input type="text" readonly id="pay_bon" name="pay_bon" class="form-control text-end" placeholder="0">
        </div>
      </div>
      <div class="col-md-4">
        <div class="pt-2">
          <button class="btn btn-sm btn-success" id="pay_all_bon" type="button">Potong Semu Bon</button>
        </div>
      </div>
    </div>
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-bold h5">Bonus</label>
      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-text">Rp.</span>
          <input type="text" id="bonus" name="bonus" class="form-control text-end" placeholder="0">
        </div>
      </div>
    </div>
    <div class="mb-2 row">
      <label for="" class="col-md-3 fw-bold h4">Sisa Gaji</label>
      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-text">Rp.</span>
          <input type="text" readonly name="thp_salary" id="thp_salary" class="form-control text-end" placeholder="0" value="">
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <h5 class="fw-bold">Sisa Kasbon</h5>
    <div class="alert alert-danger fade show" role="alert">
      <strong>Rp. <?= (isset($kasbon->sisa_kasbon)) ? number_format($kasbon->sisa_kasbon) : '0'; ?></strong>
    </div>
    <input type="hidden" name="total_ksb" id="total_ksb" value="<?= (isset($kasbon->sisa_kasbon)) ? number_format($kasbon->sisa_kasbon) : '0';  ?>">
  </div>

</div>
<hr>
<div class="row">
  <div class="offset-2 col-md-3">
    <button type="button" class="btn btn-primary" id="save"><i class="fa fa-save"></i> Simpan</button>
    <button type="button" class="btn btn-danger" onclick="location.href =siteurl+controller"><i class="fa fa-reply"></i> Kembali</button>
  </div>
</div>