  <div class="text-center">
    <h1 style="font-size: 24px;">RINCIAN KARYAWAN</h1>
    <div style="font-size: 14px;">Bulan : <?= $salary->month_name; ?></div>
  </div>
  <hr>

  <table class="table-sm table-data">
    <tbody>
      <tr>
        <td width="20%">Nama Karyawan</td>
        <td>: <strong><?= $salary->employee_name; ?></strong></td>
        <td></td>
        <td width="20%">Bon Bulan Lalu</td>
        <td>: Rp. <?= ($salary->last_month_kasbon) ? number_format($salary->last_month_kasbon) : ''; ?></td>
      </tr>
      <tr>
        <td>Bagian</td>
        <td>: <?= $salary->position_name; ?></td>
        <td></td>
        <td width="20%">Bayar Kasbon</td>
        <td>: Rp. <?= ($salary->pay_debt) ? number_format($salary->pay_debt) : '0'; ?></td>
      </tr>
      <tr>
        <td>Libur /Bulan</td>
        <td>: <?= $salary->leave_allowance; ?> Hari</td>
        <td></td>
        <td width="20%">Sisa Kasbon</td>
        <td>: Rp. <?= ($salary->remain_kasbon) ? number_format($salary->remain_kasbon) : ''; ?></td>
      </tr>
    </tbody>
  </table>
  <hr>

  <table class="table-sm table-data">
    <tbody>
      <tr>
        <td width="20%">Gaji Pokok/Bulan</td>
        <td>: <strong>Rp. <?= number_format($salary->monthly_salary); ?></strong></td>
        <td></td>
        <td>Masuk Kerja</td>
        <td>: <?= $salary->work_days; ?> Hari</td>

      </tr>
      <tr>
        <td>Jumlah Hari</td>
        <td>: <?= $salary->days_month; ?> Hari</td>
        <td></td>
        <td>Libur/Tidak Masuk</td>
        <td>: <?= $salary->actual_leave; ?> Hari</td>

      </tr>
      <tr>
        <td width="20%">Harian</td>
        <td>: Rp. <?= number_format($salary->dayli_salary); ?></td>
        <td></td>
        <td>Libur dipotong Gaji</td>
        <td>: <?= $salary->not_pay_day; ?> Hari</td>

      </tr>
      <tr>
        <td width="20%">Bonus</td>
        <td>: Rp. <?= number_format($salary->bonus); ?></td>
        <td></td>
        <td width="20%">Potong Gaji</td>
        <td>: Rp. <?= number_format($salary->cut_salary); ?></td>
      </tr>
      <tr>
        <td style="border-bottom: 1px solid;"></td>
        <td style="border-bottom: 1px solid;"></td>
        <td></td>
        <td style="border-bottom: 1px solid;" width="20%">Potong Bon </td>
        <td style="border-bottom: 1px solid;">: Rp. <?= number_format($salary->pay_debt); ?></td>
      </tr>

      <tr>
        <td>Total Gaji</td>
        <td>: <strong>Rp. <?= number_format(($salary->days_month * $salary->dayli_salary) + $salary->bonus); ?></strong></td>
        <td></td>
        <td>Total Potongan</td>
        <td>: <strong>Rp. <?= number_format($salary->pay_debt + $salary->cut_salary); ?></strong></td>
      </tr>
    </tbody>
  </table>
  <br>
  <br>
  <h3>Total Gaji Diterima : Rp. <?= number_format($salary->take_home_pay); ?></h3>