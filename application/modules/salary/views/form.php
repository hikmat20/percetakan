 <form id="form-sallary">
   <div class="card">
     <div class="card-body">
       <div class="mb-3 row">
         <label for="employee_id" class="form-label col-md-2 fw-bold">Pilih Karyawan <span class="text-danger">*</span></label>
         <div class="col-md-4">
           <select name="employee_id" id="employee_id" class="form-select select" data-allow-clear="true">
             <option value=""></option>
             <?php foreach ($employees as $emp) : ?>
               <option value="<?= $emp->id; ?>"><?= $emp->employee_name; ?></option>
             <?php endforeach; ?>
           </select>
           <small class="form-text invalid-feedback text-danger">Karyawan tidakboleh kosong!</small>
         </div>
       </div>

       <div id="data-salary"></div>
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

     $(document).on('change', '#sdate,#edate', function() {
       let sdate = $('#sdate').val() || 0;
       let edate = $('#edate').val() || 0;


       var date1 = new Date(sdate);
       var date2 = new Date(edate);

       // To calculate the time difference of two dates
       var Difference_In_Time = date2.getTime() - date1.getTime();

       // To calculate the no. of days between two dates
       var totalDay = Difference_In_Time / (1000 * 3600 * 24);

       if (parseInt(totalDay) <= 0) {
         totalDay = 0
       }

       $('#days_month').val(totalDay)
       $('#text_days_month').text(totalDay)
     })

     $(document).on('change input', '#actual_leave,#sdate,#edate,#monthly_salary', function() {
       let leave_allowance = $('#leave_allowance').val() || 0;
       let monthly_salary = $('#monthly_salary').val().replace(/[\.,]/g, '') || 0
       let days_month = $('#days_month').val() || 0
       let not_pay_day = 0
       let actual = $('#actual_leave').val() || 0;

       if (parseInt(actual) >= parseInt(leave_allowance)) {
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
       thp_salary = (parseInt(total_salary) - parseInt(pay_bon)) + parseInt(bonus)
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

     $(document).on('change input', '#pay_bon', function() {
       let total_salary = $('#total_salary').val().replace(/[\.,]/g, '') || 0
       let pay_bon = $(this).val().replace(/[\.,]/g, '') || 0

       thp_salary = parseInt(total_salary) - parseInt(pay_bon)
       $('#thp_salary').val(new Intl.NumberFormat().format(thp_salary))
     })

     $(document).on('click', '#save', function() {
       let formdata = new FormData($('#form-sallary')[0])
       let actual_leave = $('#actual_leave').val()
       let date = $('#date').val()
       let month = $('#month').val()

       if (date == '') {
         $('#date').addClass('is-invalid')
         Swal.fire({
           title: 'Perhatian!',
           text: 'Data gaji belum lengkap.!',
           icon: 'warning',
           timer: 3000
         })
       } else if (month == '') {
         $('#month').addClass('is-invalid')
         Swal.fire({
           title: 'Perhatian!',
           text: 'Data gaji belum lengkap.!',
           icon: 'warning',
           timer: 3000
         })
         //  } else if (actual_leave == '') {
         //    $('#actual_leave').addClass('is-invalid')
         //    Swal.fire({
         //      title: 'Perhatian!',
         //      text: 'Data gaji belum lengkap.!',
         //      icon: 'warning',
         //      timer: 3000
         //    })

       } else {
         $('#actual_leave').removeClass('is-invalid')
         $('#date').removeClass('is-invalid')
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
                 icon: 'warning',
                 text: result.msg,
                 timer: 5000
               })
             }
           },
           error: function(result) {
             Swal.fire({
               title: "Error!",
               text: "Server timeout..",
               icon: 'error',
             })
           }

         })
       }

     })

   })
 </script>