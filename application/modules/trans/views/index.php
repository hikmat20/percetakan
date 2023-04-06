<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">Data Transaksi</h3>
            <!-- <button class="btn btn-primary"><i class="fa fa-plus"></i> Transaksi Baru</button> -->
            <a onclick="loading()" href="<?= base_url('newsales'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Transaksi Baru</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="datatable table table-striped table-sm">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>No. Trans</th>
                        <th>Pelannggan</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Total Bayar</th>
                        <th class="text-end">Sisa</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Waktu</th>
                        <th width="120px">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 0;
                    foreach ($data as $dt) : $n++ ?>
                        <tr>
                            <td><?= $n; ?></td>
                            <td><?= $dt->id; ?></td>
                            <td><?= $dt->customer_name; ?></td>
                            <td class="text-end"><?= number_format($dt->grand_total); ?></td>
                            <td class="text-end text-success"><?= number_format($dt->total_payment); ?></td>
                            <td class="text-end text-danger"><?= number_format($dt->balance); ?></td>
                            <td class="text-center"><?= $sts[$dt->status]; ?></td>
                            <td class="text-center text-primary"><?= ucfirst($usr[$dt->created_by]); ?></td>
                            <td class="text-center"><?= $dt->created_at; ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-default text-info mb-1 view" data-id="<?= $dt->id; ?>" title="Lihat"><i data-feather="search"></i></button>
                                <?php if ($dt->status == 'OPN' || $dt->status == 'PND') : ?>
                                    <a href="<?= base_url("newsales/edit/$dt->id"); ?>" class="btn btn-sm btn-default text-primary mb-1 edit" title="Ubah"><i data-feather="edit-3"></i></a>
                                    <button onclick="cancel('<?= $dt->id; ?>')" class="btn btn-sm btn-default text-danger mb-1 cancel" title="Batal"><i data-feather="x-circle"></i></button>
                                <?php endif; ?>
                                <!-- <a href="<?= base_url("sales/view/$dt->id"); ?>" class="mb-1 btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> Hapus</a> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-trn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Data Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewData">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
        $(document).on('click', '.view', function() {
            let id = $(this).data('id');

            if (id) {
                $.ajax({
                    url: siteurl + controller + 'view',
                    type: 'POST',
                    data: {
                        id
                    },
                    success: function(result) {
                        if (result) {
                            $('#viewData').html(result)
                            $('#modal-trn').modal('show');
                        }
                    },
                    error: function(result) {
                        Swal.fire({
                            title: "Error!",
                            icon: 'error',
                            text: result.msg,
                            timer: 3000
                        })
                    }
                })
            }
        })

        $(document).on('click', '#print_bill', function() {
            let id = $(this).data('id');
            if (id) {
                Cetak(id);
            }
        })

        function Cetak(id = '') {
            console.log(id);
            if (id) {
                $.ajax({
                    url: siteurl + 'sales/Cetak',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id
                    },
                    success: function(result) {
                        console.log(result);
                        if (result.status == 1) {
                            Swal.fire({
                                title: "Print Struk!",
                                icon: 'success',
                                text: result.msg
                            })
                        } else {
                            Swal.fire({
                                title: "Peringatan!",
                                icon: 'warning',
                                text: 'Printer bermasalah!. ' + result.msg
                            })
                        }
                    },
                    error: function(result) {
                        Swal.fire({
                            title: "Error!",
                            icon: 'error',
                            text: 'Printer bermasalah!. Mohon pastikan printer dalam keadaan menyala dan terkoneksi dengan baik.'
                        })
                    }
                })
            } else {
                Swal.fire({
                    title: "Informasi!",
                    icon: 'info',
                    text: 'Transaksi tidak valid.'
                })
            }
        }
    })

    $(document).on('click', '.btn-nav', function() {
        $('.btn-nav').removeClass('active');
        $(this).addClass('active');
    })

    function cancel(id = '') {
        if (id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Data transaksi akan dibatalkan?',
                icon: 'question',
                showCancelButton: true,
            }).then((value) => {
                if (value.isConfirmed == true) {
                    $.ajax({
                        url: siteurl + controller + 'cancel',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            id
                        },
                        success: function(result) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: result.msg,
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                location.reload()
                            })
                        },
                        error: function(result) {
                            Swal.fire({
                                title: 'Peringatan!',
                                text: result.msg,
                                icon: 'warning',
                                timer: 3000
                            })
                        }
                    })
                }
            })
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Data tidak valid.',
                icon: 'error',
                timer: 3000
            })
        }
    }
</script>