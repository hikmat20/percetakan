<form id="form-sallary">

  <input type="hidden" value="<?= $salary->id; ?>" name="id" id="id" class="form-control" required="required" title="">

  <div class="card">
    <div class="card-body">
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
            <label for="" class="col-md-3 fw-">Tanggal Gajian</label>
            <div class="col-md-9">
              <div class="input-group">
                <input type="date" class="form-control " placeholder="YYYY-mm-dd" name="date" id="date" value="<?= $salary->date; ?>">
                <span class="input-group-text">Bulan</span>
                <select name="month" id="month" class="form-select">
                  <option value="">~ Bulan ~</option>
                  <?php for ($i = 1; $i <= count($month_name); $i++) : ?>
                    <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT); ?>" <?= (str_pad($i, 2, '0', STR_PAD_LEFT) == $salary->month) ? 'selected' : ''; ?>><?= $month_name[str_pad($i, 2, '0', STR_PAD_LEFT)]; ?></option>
                  <?php endfor ?>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-2 row">
            <label for="" class="col-md-3 fw-">Jumah Hari</label>
            <div class="col-md-4">
              <input type="hidden" name="days_month" id="days_month" value="<?= $salary->days_month; ?>">
              : <span class="badge bg-info h5"><span id="text_days_month"><?= $salary->days_month; ?></span> Hari</span>
            </div>
          </div>

          <div class="mb-2 row">
            <label for="" class="col-md-3 fw-">Libur/Tidak Masuk</label>
            <div class="col-md-4">
              <div class="input-group">
                <input type="text" name="actual_leave" id="actual_leave" value="<?= $salary->actual_leave; ?>" class="form-control text-end" placeholder="0">
                <span class="input-group-text">Hari</span>
                <span class="invalid-feedback text-red">Jumlah hari tidak masuk tidak boleh kosong!</span>
              </div>
            </div>
          </div>
          <div class="mb-2 row">
            <label for="" class="col-md-3 fw-">Libur dipotong Gaji</label>
            <div class="col-md-4">
              <div class="input-group">
                <input type="text" readonly name="not_pay_day" value="<?= $salary->not_pay_day; ?>" id="not_pay_day" class="form-control text-end" placeholder="0">
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
                <input type="text" class="form-control text-end currency" placeholder="0" name="monthly_salary" id="monthly_salary" value="<?= number_format($salary->monthly_salary); ?>">
              </div>
            </div>
            <div class="col-md-5">
              <div class="input-group">
                <span class="input-group-text">Harian</span>
                <span class="input-group-text">Rp.</span>
                <input type="text" readonly class="form-control text-end" placeholder="0" name="dayli_salary" id="dayli_salary" value="<?= number_format($salary->dayli_salary); ?>">
              </div>
            </div>
          </div>

          <div class="mb-2 row">
            <label for="" class="col-md-3 fw-">Masuk Kerja</label>
            <div class="col-md-4">
              <div class="input-group">
                <input type="text" readonly name="work_days" id="work_days" class="form-control text-end" placeholder="0" value="<?= number_format($salary->work_days); ?>">
                <span class="input-group-text">Hari</span>
              </div>
            </div>
            <div class="col-md-5">
              <div class="input-group">
                <span class="input-group-text">Potong</span>
                <span class="input-group-text">Rp.</span>
                <input type="text" readonly name="cut_salary" id="cut_salary" class="form-control text-end" placeholder="0" value="<?= number_format($salary->cut_salary); ?>">
              </div>
            </div>
          </div>
          <hr>
          <div class="mb-2 row">
            <label for="" class="col-md-3 fw-bold h4">Total Gaji</label>
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Rp.</span>
                <input type="text" readonly class="form-control text-end" name="total_salary" id="total_salary" placeholder="0" value="<?= number_format($salary->total_salary); ?>">
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
                <input type="text" readonly id="pay_bon" name="pay_bon" value="<?= number_format($salary->pay_debt); ?>" class="form-control text-end  numeric currency" placeholder="0">
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
                <input type="text" id="bonus" name="bonus" value="<?= number_format($salary->bonus); ?>" class="form-control text-end numeric currency" placeholder="0">
              </div>
            </div>
          </div>
          <div class="mb-2 row">
            <label for="" class="col-md-3 fw-bold h4">Sisa Gaji</label>
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Rp.</span>
                <input type="text" readonly name="thp_salary" id="thp_salary" class="form-control text-end numeric currency" placeholder="0" value="<?= number_format($salary->take_home_pay); ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <h5 class="fw-bold text-danger"><i class="fa fa-file-text"></i> Data Kasbon</h5>
          <div class="card border shadow-none">
            <div class="card-body">
              <table class="table table-sm table-condensed">
                <thead>
                  <tr class="table-light">
                    <th>Bulan</th>
                    <th class="text-end">Nominal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $n = $total_ksb = 0;
                  foreach ($dt_kasbon as $ksb) : $n++;
                    $total_ksb += $ksb->total_value; ?>
                    <tr>
                      <td><?= $month_name[date("m", strtotime($ksb->date))]; ?></td>
                      <td class="text-end"><a href="javascript:void(0)"><?= number_format($ksb->total_value); ?></a></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <input type="hidden" name="total_ksb" id="total_ksb" value="<?= $total_ksb; ?>">
            </div>
          </div>
          <hr>
          <h5 class="fw-bold text-success"><i class="fa fa-history"></i> Bayar Kasbon</h5>
          <div class="card border shadow-none mb-5">
            <div class="card-body">
              <table class="table table-sm">
                <thead>
                  <tr class="table-light">
                    <th>Tanggal</th>
                    <th class="text-end">Nominal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?= (isset($pay_debt) ? $pay_debt->date : ''); ?>
                      <input type="hidden" name="pay_debt_id" id="pay_debt_id" value="<?= isset($pay_debt) ? $pay_debt->id : ''; ?>">
                    </td>
                    <td class="text-end"><a href="javascript:void(0)"><?= number_format(isset($pay_debt) ? $pay_debt->payment_value : '0'); ?></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <h4 class="fw-bold text-danger text-end">Sisa Kasbon : Rp. <?= number_format($total_ksb - (isset($pay_debt) ? $pay_debt->payment_value : 0)); ?></h4>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="offset-2 col-md-3">
          <button type="button" class="btn btn-primary" id="save"><i class="fa fa-save"></i> Simpan</button>
          <button type="button" class="btn btn-danger" onclick="location.href =siteurl+controller"><i class="fa fa-reply"></i> Kembali</button>
        </div>
      </div>
    </div>
  </div>
</form>


<script>
  const getDays = (year, month) => {
    return new Date(year, month, 0).getDate();
  };

  $(document).ready(function() {
    $(document).on('change', '#employee_id', function() {
      let id_emp = $(this).val();
      console.log(id_emp);
      if (id_emp) {
        $('#data-salary').load(siteurl + controller + 'load_employee/' + id_emp)

      } else {
        $('#data-salary').html('')
      }
    })

    $(document).on('change', '#month,#year', function() {
      let month = $('#month').val() || 0;
      let year = $('#year').val() || 0;
      $('#days_month').val(getDays(year, month))
      $('#text_days_month').text(getDays(year, month))
    })

    $(document).on('change input', '#actual_leave,#month,#year,#monthly_salary', function() {
      let leave_allowance = $('#leave_allowance').val() || 0;
      let monthly_salary = $('#monthly_salary').val().replace(/[\.,]/g, '') || 0
      let days_month = $('#days_month').val() || 0
      let not_pay_day = 0
      let actual = $('#actual_leave').val() || 0;

      if (actual >= leave_allowance) {
        not_pay_day = parseInt(actual) - parseInt(leave_allowance)
        $('#not_pay_day').val(not_pay_day)
        $('#bonus').prop('readonly', true).val('')
      } else {
        $('#not_pay_day').val(0)
        $('#bonus').prop('readonly', false).val(new Intl.NumberFormat().format(300000))
      }

      work_days = parseInt(days_month) - parseInt(not_pay_day)
      $('#work_days').val(work_days)

      dayli_salary = parseInt(monthly_salary) / parseInt(days_month)
      $('#dayli_salary').val(new Intl.NumberFormat().format(dayli_salary.toFixed()))

      total_salary = parseInt(work_days) * parseInt(dayli_salary)
      $('#total_salary').val(new Intl.NumberFormat().format(total_salary.toFixed()))

      cut_salary = parseInt(not_pay_day) * parseInt(dayli_salary)
      $('#cut_salary').val(new Intl.NumberFormat().format(cut_salary.toFixed()))

      let pay_bon = $('#pay_bon').val().replace(/[\.,]/g, '') || 0
      let bonus = $('#bonus').val().replace(/[\.,]/g, '') || 0
      thp_salary = (parseInt(total_salary) + parseInt(bonus)) - parseInt(pay_bon)
      $('#thp_salary').val(new Intl.NumberFormat().format(thp_salary.toFixed()))

    })

    $(document).on('change', '#check_pay_bon', function() {
      if ($(this).is(':checked', true)) {
        $('#pay_bon').prop('readonly', false).change()
      } else {
        $('#pay_bon').prop('readonly', true).val('').change()
      }
    })

    $(document).on('click', '#pay_all_bon', function() {
      let total_bon = $('#total_ksb').val() || 0
      if ($('#check_pay_bon').is(':checked', true)) {
        $('#pay_bon').val(new Intl.NumberFormat().format(total_bon)).change()
      } else {
        $('#pay_bon').val('').change()
      }
    })

    $(document).on('change input', '#pay_bon,#bonus', function() {
      let total_salary = $('#total_salary').val().replace(/[\.,]/g, '') || 0
      let pay_bon = $('#pay_bon').val().replace(/[\.,]/g, '') || 0
      let bonus = $('#bonus').val().replace(/[\.,]/g, '') || 0

      thp_salary = (parseInt(total_salary) + parseInt(bonus)) - parseInt(pay_bon)
      $('#thp_salary').val(new Intl.NumberFormat().format(thp_salary))
    })

    $(document).on('click', '#save', function() {
      let formdata = new FormData($('#form-sallary')[0])
      let actual_leave = $('#actual_leave').val()

      if (actual_leave == '') {
        $('#actual_leave').addClass('is-invalid')
        Swal.fire({
          title: 'Perhatian!',
          text: 'Data gaji belum lengkap.!',
          icon: 'warning',
          timer: 3000
        })

      } else {
        $('#actual_leave').removeClass('is-invalid')
        $.ajax({
          url: siteurl + controller + 'save_salary',
          data: formdata,
          type: 'POST',
          contentType: false,
          processData: false,
          dataType: 'JSON',
          cache: false,
          async: false,
          success: function(result) {
            if (result.status == 1) {
              Swal.fire({
                title: "Berhasil!",
                icon: 'success',
                text: result.msg,
                timer: 2000
              }).then(function() {
                window.open(siteurl + controller + 'salary_detail/' + result.salary_id)
                location.href = siteurl + controller
              })
            } else {
              Swal.fire({
                title: "Gagal!",
                icon: 'error',
                text: result.msg,
                timer: 5000
              })
            }
          },
          error: function(result) {
            Swal.fire({
              title: "Internal Server Error!",
              icon: 'error',
              text: result.msg
            })
          }

        })
      }

    })

  })
</script>