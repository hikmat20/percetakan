<!DOCTYPE html>
<html lang="en">

<head>
  <title>Slip Gaji </title>
</head>

<style>
  body,
  span,
  h1,
  h2,
  h3,
  h4,
  h5,
  label,
  a,
  td,
  table,
  tr,
  th {
    font-family: Arial, Helvetica, sans-serif, Geneva, Verdana, sans-serif !important;
    font-size: 9pt;
    color: #000 !important;
  }

  table {
    border-collapse: collapse;
    width: 100%;

  }

  table.table-data th,
  table.table-data td {
    /* border: 1px solid #eaeaea; */
    padding: 2px;
  }

  .bg-gray {
    background-color: #eaeaea;
  }

  .text-start {
    text-align: left;
  }

  .text-end {
    text-align: right;
  }

  .text-center {
    text-align: center;
  }
</style>
<!-- <link rel="stylesheet" href="<?= base_url('/assets/libs/bootstrap/dist/css/bootstrap.min.css'); ?>"> -->
<!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/css/theme.min.css"> -->

<body>
  <table width="100%">
    <tr>
      <td><span style="font-size: 24px;font-weight:bold;">SLIP GAJI KARYAWAN</span></td>
      <td align="right" style="font-size: 16px;font-weight:bold;"><strong><?= $salary->employee_name; ?></strong></td>
    </tr>
    <tr>
      <td>Bulan : <?= $salary->month_name; ?></td>
      <td align=" right"> <?= $salary->position_name; ?></td>
    </tr>
  </table>
  <hr>

  <table class="table table-sm table-data table-bordered">
    <tbody>
      <tr>
        <td width="20%">Gaji Pokok</td>
        <td>: <strong>Rp. <?= number_format($salary->monthly_salary); ?></strong></td>
        <td></td>
        <td>Jatah Libur</td>
        <td>: <?= $salary->leave_allowance; ?> Hari</td>
      </tr>
      <tr>
        <td>Jumlah Hari</td>
        <td>: <?= $salary->days_month; ?> Hari</td>
        <td></td>
        <td>Libur Kerja</td>
        <td>: <?= $salary->actual_leave; ?> Hari</td>

      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Pendapatan</td>
        <td>: <?= $salary->work_days; ?> Hari</td>

      </tr>
    </tbody>
  </table>
  <hr style="margin-top:0px ;">
  <table class="table table-sm table-data table-bordered">
    <tbody>
      <tr>
        <td>Total Gaji</td>
        <td width="15%" class="text-">: <strong>Rp. <?= number_format(($salary->total_salary)); ?></strong></td>
        <td width="10%"></td>
        <td width="20%">Sisa bon</td>
        <td width="15%" class="text">: Rp. <?= number_format($salary->last_month_kasbon); ?></td>
      </tr>
      <tr>
        <td width="20%">Bonus</td>
        <td class="">
          <div class="d-flex justify-content-between align-items-center">
            <span> :</span>
            <span> Rp. <?= number_format($salary->bonus); ?></span>
          </div>
        </td>
        <td></td>
        <td></td>
        <td> <?php //number_format($salary->current_month_kasbon); 
              ?></td>

      </tr>
      <tr>
        <td width="20%" colspan="2">
          <hr class="my-0">
        </td>
        <td></td>
        <td width="20%" colspan="2">
          <hr class="my-0">
        </td>
      </tr>
      <tr>
        <td width="20%" style="font-weight:bold ;">Total</td>
        <td style="font-weight:bold ;">: Rp. <?= number_format($salary->total_salary + $salary->bonus); ?></td>
        <td></td>
        <td width="20%" style="font-weight: bold;">Total Bon </td>
        <td style="font-weight: bold;">: Rp. <?= number_format($salary->last_month_kasbon + $salary->current_month_kasbon); ?></td>
      </tr>
      <tr>
        <td width="20%">Potong Kasbon</td>
        <td>: Rp. <?= number_format($salary->pay_debt); ?></td>
        <td></td>
        <td width="20%">Bayar kasbon </td>
        <td>: Rp. <?= number_format($salary->pay_debt); ?></td>
      </tr>
      <tr>
        <td colspan="2">
          <hr style="margin:0px">
        </td>
        <td></td>
        <td colspan="2">

        </td>
      </tr>
      <tr>
        <td>Total Gaji</td>
        <td>: <strong>Rp. <?= number_format($salary->total_salary - $salary->pay_debt); ?></strong></td>
        <td></td>
        <td style="border:1px #000;border-style: solid none solid solid;padding-left:5px !important;" width="20%">Sisa Kasbon</td>
        <td style="border:1px #000;border-style: solid solid solid none;padding:5px !important;">: Rp. <?= number_format($salary->remain_kasbon); ?></td>
      </tr>
    </tbody>
  </table>
  <br>
  <br>
  <h3>Total Gaji Diterima : Rp. <?= number_format($salary->take_home_pay); ?></h3>

</body>

</html>

<!-- [days_month] => 30



[total_salary] => 2249991
[pay_debt] => 0
[take_home_pay] => 2249991
[created_at] => 2022-06-18 11:45:57
[created_by] => 2
[modified_at] =>
[modified_by] => -->