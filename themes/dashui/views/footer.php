</div>
</div>
</div>
<!-- Libs JS -->
<script src="<?= base_url(); ?>themes/dashui/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/feather-icons/dist/feather.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/prismjs/components/prism-core.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/prismjs/components/prism-markup.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/prismjs/plugins/line-numbers/prism-line-numbers.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/dropzone/dist/min/dropzone.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/sweetalert2/sweetalert2.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets\libs\datatables\dataTables.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets\libs\datatables\dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url(); ?>themes/dashui/assets/libs/select2/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Theme JS -->
<script src="<?= base_url(); ?>themes/dashui/assets/js/theme.min.js"></script>
<!-- page script -->
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        // $("#example1").DataTable();
        $('.select').select2({
            theme: "bootstrap-5",
            placeholder: '~ Pilih ~',
            width: '100%',
            allowClear: true,
        })
    })

    $(document).on('input', '.currency', function() {
        if (this.value) {
            const value = this.value.replace(/[\.,]/g, '');
            this.value = new Intl.NumberFormat().format(value)
            // parseFloat(value).toLocaleString('id-ID', {
            //     style: 'decimal',
            //     maximumFractionDigits: 2,
            //     // minimumFractionDigits: 2
            // });
        }
    });

    $(document).on("keypress keyup blur", '.numeric', function(event) {
        // $(this).val($(this).val().replace(/[^\d].+/, ""));
        if (event.which !== 8 && event.which !== 0 && event.which < 48 || event.which > 57) {
            event.preventDefault();
        }
    });
</script>