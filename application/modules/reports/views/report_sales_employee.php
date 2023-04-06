<h2>Laporan Transaksi</h2>
<form id="form-report">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <span for="" class="form-label col-lg-1 control-label">Tanggal :</span>
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        <input type="text" name="date" id="dates" class="form-control" autocomplete="off" title="">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <span for="" class="form-label col-lg-1 control-label">Karyawan :</span>
                <div class="col-lg-4">
                    <select class="select form-select" name="user" id="user">
                        <option value=""></option>
                        <?php foreach ($users as $usr) : ?>
                            <option value="<?= $usr->id_user; ?>"><?= ucfirst($usr->full_name); ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <span for="" class="form-label col-lg-1 control-label"></span>
                <div class="col-lg-4">
                    <button type="button" class="btn btn-primary" id="getData">Tampil</button>
                    <button type="button" class="btn btn-warning" onclick="location.href=siteurl+controller+'report_sales_employee/'"><i class="fa fa-refresh"></i> Reset</button>
                </div>
            </div>

        </div>
    </div>
</form>
<!-- Modal -->
<script>
    $(document).ready(function() {
        $('input[name="date"]').daterangepicker();
        // $('table').DataTable();
        Datatbles();
    })

    $(document).on('click', '#getData', function() {

        let user = $('#user').val();
        let dates = $('#dates').val();
        let split = dates.split(' - ');
        // console.log(split);
        var sDate = split[0]
        var eDate = split[1]
        sDate = sDate.replaceAll('/', '-');
        eDate = eDate.replaceAll('/', '-');

        location.href = siteurl + controller + 'printReport/' + sDate + "/" + eDate + "/" + user
    })

    function Datatbles() {
        $('.datatable').DataTable();
    }

    function printSummary() {

        // var printData = load(siteurl + controller + 'printSummary'
        //     console.log(printData); +
        // window.frames["print_frame"].load(siteurl + controller + 'printSummary')
        // newWin = window.open("");
        // newWin.document.write(printData.outerHTML);
        // newWin.print();
        // newWin.close();
        // window.frames["print_frame"][0].src = siteurl + controller + 'printSummary';
        // $('iframe[name="print_frame"]').src = siteurl + controller + 'printSummary'
        // document.getElementsByName('print_frame')[0].src = siteurl + controller + 'printSummary';
        // window.frames["print_frame"].document.body.innerHTML = document.getElementById("v-pills-summary").innerHTML;
        fetch(siteurl + controller + 'printSummary')
            .then(function(response) {
                return response.text();
            })
            .then(function(body) {
                document.querySelector('iframe[name="print_frame"]').innerHTML = body;
            });

        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }

    // function printDiv() {
    //     window.frames["print_frame"].document.body.innerHTML = document.getElementById("v-pills-summary").innerHTML;
    //     window.frames["print_frame"].window.focus();
    //     window.frames["print_frame"].window.print();
    // }
</script>